<?php
namespace tests\foundation\misc;

use deflou\interfaces\stages\IStageBeforeActionRun;
use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\components\plugins\Plugin;

/**
 * Class PluginBeforeActionRun
 *
 * @package tests\foundation\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginBeforeActionRun extends Plugin implements IStageBeforeActionRun
{
    /**
     * @param IApplicationAction $action
     * @param IApplicationEvent $event
     * @return IApplicationAction
     */
    public function __invoke(IApplicationAction $action, IApplicationEvent $event): IApplicationAction
    {
        $action->addParameterByValue('before_action_run', true);

        return $action;
    }
}
