<?php
namespace tests\foundation\applications;

use deflou\components\applications\activities\Activity;
use deflou\components\applications\activities\THasAction;
use deflou\components\applications\activities\THasEvent;
use deflou\components\applications\Application;
use deflou\components\applications\ApplicationSample;
use deflou\components\applications\THasApplication;
use deflou\interfaces\applications\activities\IHasAction;
use deflou\interfaces\applications\activities\IHasEvent;
use deflou\interfaces\applications\IApplicationSample;
use deflou\interfaces\applications\IHasApplication;
use Dotenv\Dotenv;
use extas\components\Item;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest
 * @package tests\foundation\applications
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationTest extends TestCase
{
    use TSnuffRepositoryDynamic;
    use THasMagicClass;

    public function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->createSnuffDynamicRepositories([
            ['applications', 'name', Application::class],
            ['activities', 'name', Activity::class]
        ]);
    }

    protected function tearDown(): void
    {
        $this->deleteSnuffDynamicRepositories();
    }

    public function testSample()
    {
        $sample = new ApplicationSample();
        $this->assertEquals(IApplicationSample::SUBJECT, $sample->__subject());
    }

    public function testHasApplication()
    {
        $item = new class([
            IHasApplication::FIELD__APPLICATION_NAME => 'test'
        ]) extends Item {
            use THasApplication;
            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->getMagicClass('applications')->create(new Application([
            Application::FIELD__NAME => 'test',
            Application::FIELD__TITLE => 'is ok'
        ]));

        $this->assertEquals('test', $item->getApplicationName());
        $this->assertNotEmpty($item->getApplication());
        $this->assertEquals('is ok', $item->getApplication()->getTitle());

        $item->setApplicationName('is ok');
        $this->assertEquals('is ok', $item->getApplicationName());
    }

    public function testHasEvent()
    {
        $item = new class([
            IHasEvent::FIELD__EVENT_NAME => 'test'
        ]) extends Item {
            use THasEvent;
            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test',
            Activity::FIELD__TITLE => 'is ok',
            Activity::FIELD__TYPE => Activity::TYPE__EVENT
        ]));

        $this->assertEquals('test', $item->getEventName());
        $this->assertNotEmpty($item->getEvent());
        $this->assertEquals('is ok', $item->getEvent()->getTitle());

        $item->setEventName('is ok');
        $this->assertEquals('is ok', $item->getEventName());
    }

    public function testHasAction()
    {
        $item = new class([
            IHasAction::FIELD__ACTION_NAME => 'test'
        ]) extends Item {
            use THasAction;
            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->getMagicClass('activities')->create(new Activity([
            Activity::FIELD__NAME => 'test',
            Activity::FIELD__TITLE => 'is ok',
            Activity::FIELD__TYPE => Activity::TYPE__ACTION
        ]));

        $this->assertEquals('test', $item->getActionName());
        $this->assertNotEmpty($item->getAction());
        $this->assertEquals('is ok', $item->getAction()->getTitle());

        $item->setActionName('is ok');
        $this->assertEquals('is ok', $item->getActionName());
    }
}
