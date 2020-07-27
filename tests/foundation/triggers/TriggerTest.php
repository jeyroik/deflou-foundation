<?php
namespace tests\foundation\triggers;

use deflou\components\triggers\actions\ApplicationAction;
use deflou\components\triggers\actions\THasApplicationAction;
use deflou\components\triggers\events\ApplicationEvent;
use deflou\components\triggers\events\THasApplicationEvent;
use deflou\components\triggers\THasTrigger;
use deflou\components\triggers\Trigger;
use deflou\interfaces\triggers\actions\IHasApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\events\IHasApplicationEvent;

use Dotenv\Dotenv;
use extas\components\Item;
use extas\components\plugins\TSnuffPlugins;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use extas\interfaces\samples\parameters\ISampleParameter;
use PHPUnit\Framework\TestCase;

/**
 * Class TriggerTest
 *
 * @package tests\foundation\triggers
 * @author jeyroik <jeyroik@gmail.com>
 */
class TriggerTest extends TestCase
{
    use TSnuffRepositoryDynamic;
    use TSnuffPlugins;
    use THasMagicClass;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->createSnuffDynamicRepositories([
            ['triggers', 'name', Trigger::class]
        ]);
    }

    public function tearDown(): void
    {
        $this->deleteSnuffDynamicRepositories();
    }

    public function testHasTrigger()
    {
        $item = new class () extends Item {
            use THasTrigger;
            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->getMagicClass('triggers')->create(new Trigger([
            Trigger::FIELD__NAME => 'test',
            Trigger::FIELD__TITLE => 'is ok'
        ]));

        $this->assertEmpty($item->getTrigger());

        $item->setTriggerName('test');
        $this->assertEquals('test', $item->getTriggerName());
        $this->assertNotEmpty($item->getTrigger());
        $this->assertEquals('is ok', $item->getTrigger()->getTitle());
    }

    public function testApplicationEvent()
    {
        $item = new class ([
            IHasApplicationEvent::FIELD__APPLICATION_EVENT => new ApplicationEvent([
                ApplicationEvent::FIELD__APPLICATION_SAMPLE_NAME => 'test.sample',
                ApplicationEvent::FIELD__SOURCE => 'test',
                ApplicationEvent::FIELD__PARAMETERS => [
                    ApplicationEvent::PARAM__SOURCE => [
                        ISampleParameter::FIELD__NAME => ApplicationEvent::PARAM__SOURCE,
                        ISampleParameter::FIELD__VALUE => ['test' => 'is ok']
                    ],
                    ApplicationEvent::PARAM__ARTIFACTS => [
                        ISampleParameter::FIELD__NAME => ApplicationEvent::PARAM__ARTIFACTS,
                        ISampleParameter::FIELD__VALUE => ['test' => 'is ok again']
                    ]
                ]
            ])
        ]) extends Item {
            use THasApplicationEvent;

            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->assertInstanceOf(IApplicationEvent::class, $item->getApplicationEvent());

        $event = $item->getApplicationEvent();
        $this->assertEquals('test.sample', $event->getApplicationSampleName());
        $this->assertEquals('test', $event->getSource());
        $this->assertEquals(['test' => 'is ok'], $event->getSourceParameters());
        $this->assertEquals(['test' => 'is ok again'], $event->getArtifatcsParameters());
    }

    public function testApplicationAction()
    {
        $item = new class ([
            IHasApplicationAction::FIELD__APPLICATION_ACTION => new ApplicationAction([
                ApplicationAction::FIELD__APPLICATION_SAMPLE_NAME => 'test.sample',
                ApplicationAction::FIELD__PARAMETERS => [
                    ApplicationAction::PARAM__SOURCE => [
                        ISampleParameter::FIELD__NAME => ApplicationAction::PARAM__SOURCE,
                        ISampleParameter::FIELD__VALUE => ['test' => 'is ok']
                    ],
                    ApplicationAction::PARAM__ARTIFACTS => [
                        ISampleParameter::FIELD__NAME => ApplicationAction::PARAM__ARTIFACTS,
                        ISampleParameter::FIELD__VALUE => ['test' => 'is ok again']
                    ]
                ]
            ])
        ]) extends Item {
            use THasApplicationAction;

            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->assertInstanceOf(IHasApplicationAction::class, $item->getApplicationAction());

        $action = $item->getApplicationAction();
        $this->assertEquals('test.sample', $action->getApplicationSampleName());
    }
}
