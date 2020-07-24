<?php
namespace tests\foundation\misc;

use deflou\components\triggers\Trigger;
use deflou\interfaces\stages\IStageCollectTriggers;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\components\plugins\Plugin;

/**
 * Class PluginCollectTriggers
 *
 * @package tests\foundation\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginCollectTriggers extends Plugin implements IStageCollectTriggers
{
    /**
     * @param IApplicationEvent $applicationEvent
     * @param array $triggers
     */
    public function __invoke(IApplicationEvent $applicationEvent, array &$triggers): void
    {
        $triggers = [
            new Trigger([
                Trigger::FIELD__ACTION_NAME => 'test action'
            ])
        ];
    }
}
