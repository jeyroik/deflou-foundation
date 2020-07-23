<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\ITrigger;

/**
 * Interface IStageCollectTriggersByAppEvent
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageCollectTriggersByAppEvent
{
    public const NAME = 'deflou.collect.triggers.by.app.event';

    /**
     * @param IApplicationEvent $applicationEvent
     * @param ITrigger[] $triggers
     */
    public function __invoke(IApplicationEvent $applicationEvent, array $triggers): void;
}
