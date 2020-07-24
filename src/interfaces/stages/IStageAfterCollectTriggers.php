<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\ITrigger;

/**
 * Interface IStageAfterCollectTriggers
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageAfterCollectTriggers
{
    public const NAME = 'deflou.after.collect.triggers';

    /**
     * @param IApplicationEvent $applicationEvent
     * @param ITrigger[] $triggers
     */
    public function __invoke(IApplicationEvent $applicationEvent, array &$triggers): void;
}
