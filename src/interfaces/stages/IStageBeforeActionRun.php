<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;

/**
 * Interface IStageBeforeActionRun
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageBeforeActionRun
{
    public const NAME = 'deflou.before.action.run';

    /**
     * @param IApplicationAction $action
     * @param IApplicationEvent $event
     * @return IApplicationAction
     */
    public function __invoke(IApplicationAction $action, IApplicationEvent $event): IApplicationAction;
}
