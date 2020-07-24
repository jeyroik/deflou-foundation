<?php
namespace tests\foundation;

use deflou\components\applications\activities\Activity;
use deflou\components\applications\Application;
use deflou\components\Deflou;
use deflou\components\Input;
use deflou\components\triggers\actions\ApplicationAction;
use deflou\components\triggers\events\ApplicationEvent;
use deflou\interfaces\IDeflou;
use deflou\interfaces\IInput;
use deflou\interfaces\servers\requests\IApplicationRequest;
use deflou\interfaces\stages\IStageAfterCollectTriggers;
use deflou\interfaces\stages\IStageAfterEventEquipment;
use deflou\interfaces\stages\IStageApplicationDetermine;
use deflou\interfaces\stages\IStageBeforeActionRun;
use deflou\interfaces\stages\IStageBeforeEventEquipment;
use deflou\interfaces\stages\IStageCollectTriggers;
use deflou\interfaces\stages\IStageEventDetermine;
use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\ITrigger;
use Dotenv\Dotenv;
use extas\components\plugins\PluginException;
use extas\components\plugins\PluginExecutable;
use extas\components\plugins\TSnuffPlugins;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use extas\interfaces\samples\parameters\ISampleParameter;
use PHPUnit\Framework\TestCase;
use tests\foundation\misc\MiscApplication;
use tests\foundation\misc\PluginApplicationDetermine;
use tests\foundation\misc\PluginBeforeActionRun;
use tests\foundation\misc\PluginBeforeEventEquipment;
use tests\foundation\misc\PluginCollectTriggers;
use tests\foundation\misc\PluginEventDetermine;

/**
 * Class DeflouTest
 *
 * @package tests\foundation
 * @author jeyroik <jeyroik@gmail.com>
 */
class DeflouTest extends TestCase
{
    use TSnuffPlugins;
    use TSnuffRepositoryDynamic;
    use THasMagicClass;

    protected IDeflou $deflou;

    public function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->deflou = new Deflou();
        $this->createSnuffDynamicRepositories([
            ['applications', 'name', Application::class],
            ['activities', 'name', Activity::class]
        ]);
    }

    protected function tearDown(): void
    {
        $this->deleteSnuffPlugins();
        $this->deleteSnuffDynamicRepositories();
    }

    public function testEmptyInput()
    {
        $output = $this->deflou->dispatchEvent(new Input());

        /**
         * Должно ругнуться на отсутствие приложения.
         */
        $this->assertTrue($output->hasErrors());
    }

    public function testDetermineApplicationSuccess()
    {
        $deflou = new class ([
            'test' => $this
        ]) extends Deflou {
            protected function determineEventApplication(IApplicationRequest $appRequest)
            {
                parent::determineEventApplication($appRequest);

                $this->test->assertTrue(
                    $appRequest->hasParameter(IApplicationRequest::PARAM__EVENT_APPLICATION)
                );

                return $appRequest;
            }
        };

        $this->createSnuffPlugin(PluginApplicationDetermine::class, [IStageApplicationDetermine::NAME]);

        $output = $deflou->dispatchEvent(new Input());

        /**
         * Должно ругнуться на отсутствие события.
         */
        $this->assertTrue($output->hasErrors());
    }

    public function testDetermineEventSuccess()
    {
        $deflou = new class ([
            'test' => $this
        ]) extends Deflou {
            protected function determineEvent(IApplicationRequest $appRequest)
            {
                parent::determineEvent($appRequest);

                $this->test->assertTrue(
                    $appRequest->hasParameter(IApplicationRequest::PARAM__EVENT)
                );

                throw new \Exception('Expected exception');
            }
        };

        $this->registerPluginForDetermine();

        $output = $deflou->dispatchEvent(new Input());

        $this->assertTrue($output->hasErrors());
        $this->assertEquals('Expected exception', $output->getMessage());
    }

    public function testUnknownEventSource()
    {
        $deflou = new class ([
            'test' => $this
        ]) extends Deflou {
            protected function createApplicationEvent(IApplicationRequest $appRequest, IInput $input): IApplicationEvent
            {
                $event = parent::createApplicationEvent($appRequest, $input);

                $eventWithoutDynamicFields = $event;
                unset(
                    $eventWithoutDynamicFields[ApplicationEvent::FIELD__ID],
                    $eventWithoutDynamicFields[ApplicationEvent::FIELD__CREATED_AT]
                );

                $this->test->assertEquals(
                    [
                        ApplicationEvent::FIELD__NAME => 'test event',
                        ApplicationEvent::FIELD__SAMPLE_NAME => 'testEvent',
                        ApplicationEvent::FIELD__APPLICATION_NAME => 'test app',
                        ApplicationEvent::FIELD__APPLICATION_SAMPLE_NAME => 'test app sample',
                        ApplicationEvent::FIELD__PARAMETERS => [
                            ApplicationEvent::PARAM__SOURCE => [
                                ISampleParameter::FIELD__NAME => ApplicationEvent::PARAM__SOURCE,
                                ISampleParameter::FIELD__VALUE => $input->__toArray()
                            ]
                        ],
                        ApplicationEvent::FIELD__SOURCE => 'unknown'
                    ],
                    $eventWithoutDynamicFields->__toArray(),
                    'Incorrect application event created: '
                    . print_r($eventWithoutDynamicFields->__toArray(), true)
                );

                return $event;
            }

            protected function equipApplicationEvent(IApplicationEvent $appEvent): IApplicationEvent
            {
                throw new \Exception('Terminated');
            }
        };

        $this->registerPluginForDetermine();

        $output = $deflou->dispatchEvent(new Input());

        /**
         * Должно ругнуться Terminated.
         */
        $this->assertTrue($output->hasErrors());
    }

    public function testDefinedEventSource()
    {
        $deflou = new class ([
            'test' => $this
        ]) extends Deflou {
            protected function createApplicationEvent(IApplicationRequest $appRequest, IInput $input): IApplicationEvent
            {
                $event = parent::createApplicationEvent($appRequest, $input);

                $eventWithoutDynamicFields = $event;
                unset(
                    $eventWithoutDynamicFields[ApplicationEvent::FIELD__ID],
                    $eventWithoutDynamicFields[ApplicationEvent::FIELD__CREATED_AT]
                );

                $need = [
                    ApplicationEvent::FIELD__NAME => 'test event',
                    ApplicationEvent::FIELD__SAMPLE_NAME => 'testEvent',
                    ApplicationEvent::FIELD__APPLICATION_NAME => 'test app',
                    ApplicationEvent::FIELD__APPLICATION_SAMPLE_NAME => 'test app sample',
                    ApplicationEvent::FIELD__PARAMETERS => [
                        ApplicationEvent::PARAM__SOURCE => [
                            ISampleParameter::FIELD__NAME => ApplicationEvent::PARAM__SOURCE,
                            ISampleParameter::FIELD__VALUE => $input->__toArray()
                        ]
                    ],
                    ApplicationEvent::FIELD__SOURCE => 'test'
                ];

                $this->test->assertEquals(
                    $need,
                    $eventWithoutDynamicFields->__toArray(),
                    'Incorrect application event created: '
                    . 'Wanted: ' . print_r($need, true)
                    . 'Got: ' . print_r($eventWithoutDynamicFields->__toArray(), true)
                );

                return $event;
            }
        };

        $this->registerPluginForDetermine();
        $this->createSnuffPlugin(PluginException::class, [IStageBeforeEventEquipment::NAME]);

        $output = $deflou->dispatchEvent(new Input([
            Deflou::INPUT__SOURCE => 'test'
        ]));

        $this->assertTrue($output->hasErrors());
        $this->assertEquals('Expected exception', $output->getMessage());
    }

    public function testEventEquipment()
    {
        $this->registerPluginForEventEquip();
        $this->createSnuffPlugin(PluginException::class, [IStageAfterEventEquipment::NAME]);

        $output = $this->deflou->dispatchEvent(new Input([Deflou::INPUT__SOURCE => 'test']));

        $this->assertTrue($output->hasErrors());
        $this->assertEquals('Expected exception', $output->getMessage());
    }

    public function testCollectTriggers()
    {
        $this->registerPluginsForCollectTriggers();
        $this->createSnuffPlugin(PluginException::class, [IStageAfterCollectTriggers::NAME]);

        $output = $this->deflou->dispatchEvent(new Input());

        $this->assertTrue($output->hasErrors());
        $this->assertEquals('Expected exception', $output->getMessage());
    }

    public function testCreateApplicationAction()
    {
        $this->registerPluginsForCollectTriggers();
        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test action',
            Activity::FIELD__SAMPLE_NAME => 'testAction',
            Activity::FIELD__APPLICATION_NAME => 'test app'
        ]));
        $this->getMagicClass('applications')->create(new Application([
            Application::FIELD__NAME => 'test app',
            Application::FIELD__CLASS => MiscApplication::class,
            Application::FIELD__SAMPLE_NAME => 'test app sample'
        ]));

        $deflou = new class ([
            'test' => $this
        ]) extends Deflou {
            protected function createApplicationAction(ITrigger $trigger): IApplicationAction
            {
                $action = parent::createApplicationAction($trigger);
                $actionWithoutDynamicData = $action;
                unset($action[IApplicationAction::FIELD__ID], $action[IApplicationAction::FIELD__CREATED_AT]);
                $this->test->assertEquals(
                    [
                        ApplicationAction::FIELD__NAME => 'test action',
                        ApplicationAction::FIELD__SAMPLE_NAME => 'testAction',
                        ApplicationAction::FIELD__APPLICATION_NAME => 'test app',
                        ApplicationAction::FIELD__APPLICATION_SAMPLE_NAME => 'test app sample',
                        ApplicationAction::FIELD__PARAMETERS => [
                            ApplicationAction::PARAM__SOURCE => [
                                ISampleParameter::FIELD__NAME => ApplicationAction::PARAM__SOURCE,
                                ISampleParameter::FIELD__VALUE => []
                            ]
                        ]
                    ],
                    $actionWithoutDynamicData->__toArray(),
                    'Incorrect action created: ' . print_r($actionWithoutDynamicData, true)
                );

                throw new \Exception('Expected exception');
            }
        };

        $output = $deflou->dispatchEvent(new Input());

        $this->assertTrue($output->hasErrors());
        $this->assertEquals('Expected exception', $output->getMessage());
    }

    public function testDispatchTrigger()
    {
        $this->registerPluginsForDispatchTrigger();
        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test action',
            Activity::FIELD__SAMPLE_NAME => 'testAction',
            Activity::FIELD__APPLICATION_NAME => 'test app'
        ]));
        $this->getMagicClass('applications')->create(new Application([
            Application::FIELD__NAME => 'test app',
            Application::FIELD__CLASS => MiscApplication::class,
            Application::FIELD__SAMPLE_NAME => 'test app sample'
        ]));

        $output = $this->deflou->dispatchEvent(new Input());

        $this->assertFalse($output->hasErrors());
        $this->assertEquals(Deflou::MSG__SUCCESS, $output->getMessage());
    }

    protected function registerPluginForDetermine(): void
    {
        $this->createSnuffPlugin(PluginApplicationDetermine::class, [IStageApplicationDetermine::NAME]);
        $this->createSnuffPlugin(PluginEventDetermine::class, [IStageEventDetermine::NAME]);
    }

    protected function registerPluginForEventEquip()
    {
        $this->registerPluginForDetermine();
        $this->createSnuffPlugin(PluginBeforeEventEquipment::class, [IStageBeforeEventEquipment::NAME]);
    }

    protected function registerPluginsForCollectTriggers()
    {
        $this->registerPluginForEventEquip();
        $this->createSnuffPlugin(PluginCollectTriggers::class, [IStageCollectTriggers::NAME]);
    }

    protected function registerPluginsForDispatchTrigger()
    {
        $this->registerPluginsForCollectTriggers();
        $this->createSnuffPlugin(PluginBeforeActionRun::class, [IStageBeforeActionRun::NAME]);
    }
}
