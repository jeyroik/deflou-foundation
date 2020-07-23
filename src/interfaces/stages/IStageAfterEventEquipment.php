<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\events\IApplicationEvent;

/**
 * Interface IStageAfterEventEquipment
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageAfterEventEquipment
{
    public const NAME = 'deflou.after.event.equipment';

    /**
     * @param IApplicationEvent $applicationEvent
     * @return IApplicationEvent
     */
    public function __invoke(IApplicationEvent $applicationEvent): IApplicationEvent;
}
