<?php
namespace tests\foundation\triggers;

use deflou\components\applications\activities\Activity;
use deflou\components\applications\activities\ActivitySample;
use deflou\components\applications\Application;
use deflou\components\applications\ApplicationSample;
use deflou\components\triggers\TriggerSample;
use deflou\components\triggers\TriggerStateHistory;
use deflou\components\triggers\Trigger;

use extas\interfaces\samples\parameters\ISampleParameter;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use extas\components\plugins\PluginRepository;
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
            ['triggers', 'name', Trigger::class]
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
}
