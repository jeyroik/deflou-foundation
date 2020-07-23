<?php
namespace tests;

use deflou\components\applications\activities\Activity;
use deflou\components\applications\activities\ActivitySample;
use deflou\components\applications\Application;
use deflou\components\applications\ApplicationSample;
use deflou\components\triggers\TriggerResponse;
use deflou\components\triggers\TriggerSample;
use deflou\components\triggers\TriggerStateHistory;
use deflou\components\triggers\Trigger;

use extas\interfaces\samples\parameters\ISampleParameter;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use extas\components\plugins\PluginRepository;
use extas\components\players\Player;
use extas\components\players\PlayerRepository;
use extas\components\plugins\TSnuffPlugins;
use extas\components\samples\parameters\SampleParameter;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

/**
 * Class TriggerTest
 *
 * @package tests
 * @author jeyroik@gmail.com
 */
class CoreTest extends TestCase
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
            ['applicationsSamples', 'name', ApplicationSample::class],
            ['applications', 'name', Application::class],
            ['activitiesSamples', 'name', ActivitySample::class],
            ['activities', 'name', Activity::class],
            ['triggers', 'name', Trigger::class],
            ['triggersResponses', 'name', TriggerResponse::class],
        ]);
        $this->registerSnuffRepos([
            'playerRepository' => PlayerRepository::class,
            'pluginRepository' => PluginRepository::class
        ]);
    }

    public function tearDown(): void
    {
        $this->deleteSnuffDynamicRepositories();
    }

    public function testSetAndGetExecutionTime()
    {
        $now = time();
        $trigger = new Trigger();
        $trigger->setExecutionCount(1);
        $trigger->setExecutionLastTime($now);
        $this->assertEquals(1, $trigger->getExecutionCount());
        $this->assertEquals($now, $trigger->getExecutionLastTime());
    }

    public function testSampleGettersAndSetters()
    {
        $sample = new TriggerSample();
        $sample->setEventParametersOptions([
            [
                ISampleParameter::FIELD__NAME => 'test',
                ISampleParameter::FIELD__VALUE => 'test-v'
            ]
        ]);
        $this->assertCount(1, $sample->getEventParametersOptions());
        $this->assertCount(1, $sample->getEventParameters());

        $sample->setEventParameters([
            new SampleParameter([
                ISampleParameter::FIELD__NAME => 'test1',
                ISampleParameter::FIELD__VALUE => 'test1-v'
            ]),
            new SampleParameter([
                ISampleParameter::FIELD__NAME => 'test2',
                ISampleParameter::FIELD__VALUE => 'test2-v'
            ])
        ]);
        $this->assertCount(2, $sample->getEventParameters());
        $this->assertEquals('test1-v', $sample->getEventParameter('test1')->getValue());
        $this->assertEquals(null, $sample->getEventParameter('test1-unknown'));

        $sample->setActionParametersOptions([
            [
                ISampleParameter::FIELD__NAME => 'test',
                ISampleParameter::FIELD__VALUE => 'test-v'
            ]
        ]);
        $this->assertCount(1, $sample->getActionParametersOptions());
        $this->assertCount(1, $sample->getActionParameters());

        $sample->setActionParameters([
            new SampleParameter([
                ISampleParameter::FIELD__NAME => 'test1',
                ISampleParameter::FIELD__VALUE => 'test1-v'
            ]),
            new SampleParameter([
                ISampleParameter::FIELD__NAME => 'test2',
                ISampleParameter::FIELD__VALUE => 'test2-v'
            ])
        ]);
        $this->assertCount(2, $sample->getActionParameters());
        $this->assertEquals('test1-v', $sample->getActionParameter('test1')->getValue());
        $this->assertEquals(null, $sample->getActionParameter('test1-unknown'));
    }

    public function testStateHistory()
    {
        $history = new TriggerStateHistory();
        $history->setStateTo('test_to');
        $history->setStateFrom('test_from');

        $this->assertEquals('test_to', $history->getStateTo());
        $this->assertEquals('test_from', $history->getStateFrom());
    }

    /**
     * @throws
     */
    public function testTriggerResponse()
    {
        $response = new TriggerResponse();

        $response->setActionApplicationName('test');
        $this->assertEquals('test', $response->getActionApplicationName());

        $this->getMagicClass('applications')->create(new Application([
            Application::FIELD__NAME => 'test',
            Application::FIELD__SAMPLE_NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getActionApplication());
        $this->assertEquals('test', $response->getActionApplication()->getName());

        $response->setActionName('test');
        $this->assertEquals('test', $response->getActionName());

        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test',
            Activity::FIELD__TYPE => Activity::TYPE__ACTION,
            Activity::FIELD__APPLICATION_NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getAction());
        $this->assertEquals('test', $response->getAction()->getName());
        $this->assertEquals('test', $response->getAction()->getApplicationName());
        $this->assertEquals('test', $response->getAction()->getApplication()->getName());

        $action = $response->getAction();
        $action->setApplicationName('test2');
        $this->assertEquals('test2', $action->getApplicationName());

        $response->setActionSampleName('test');
        $this->assertEquals('test', $response->getActionSampleName());

        $this->getMagicClass('activitiesSamples')->create(new ActivitySample([
            ActivitySample::FIELD__NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getActionSample());
        $this->assertEquals('test', $response->getActionSample()->getName());

        $response->setActionApplicationSampleName('test');
        $this->assertEquals('test', $response->getActionApplicationSampleName());

        $this->getMagicClass('applicationsSamples')->create(new ApplicationSample([
            ApplicationSample::FIELD__NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getActionApplicationSample());
        $this->assertEquals('test', $response->getActionApplicationSample()->getName());

        // event

        $response->setEventApplicationName('test');
        $this->assertEquals('test', $response->getEventApplicationName());

        $this->assertNotEmpty($response->getEventApplication());
        $this->assertEquals('test', $response->getEventApplication()->getName());

        $response->setEventName('test');
        $this->assertEquals('test', $response->getEventName());

        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test',
            Activity::FIELD__TYPE => Activity::TYPE__EVENT,
            Activity::FIELD__APPLICATION_NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getEvent());
        $this->assertEquals('test', $response->getEvent()->getName());

        $response->setEventSampleName('test');
        $this->assertEquals('test', $response->getEventSampleName());

        $this->assertNotEmpty($response->getEventSample());
        $this->assertEquals('test', $response->getEventSample()->getName());

        $response->setEventApplicationSampleName('test');
        $this->assertEquals('test', $response->getEventApplicationSampleName());

        $this->assertNotEmpty($response->getEventApplicationSample());
        $this->assertEquals('test', $response->getEventApplicationSample()->getName());

        // trigger

        $response->setTriggerName('test');
        $this->assertEquals('test', $response->getTriggerName());

        $this->getMagicClass('triggers')->create(new Trigger([
            Trigger::FIELD__NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getTrigger());
        $this->assertEquals('test', $response->getTrigger()->getName());

        // response

        $response->setResponseBody('test');
        $this->assertEquals('test', $response->getResponseBody());

        $response->setResponseStatus(200);
        $this->assertEquals(200, $response->getResponseStatus());
        $this->assertTrue($response->isSuccess());

        // player

        $response->setPlayerName('test');
        $this->assertEquals('test', $response->getPlayerName());

        $this->createWithSnuffRepo('playerRepository', new Player([
            Player::FIELD__NAME => 'test'
        ]));

        $this->assertNotEmpty($response->getPlayer());
        $this->assertEquals('test', $response->getPlayer()->getName());
    }
}
