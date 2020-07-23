<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\events\IApplicationEvent;

/**
 * Interface IStageBeforeEventEquipment
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageBeforeEventEquipment
{
    public const NAME = 'deflou.before.event.equipment';

    /**
     * @param IApplicationEvent $applicationEvent
     * @return IApplicationEvent
     */
    public function __invoke(IApplicationEvent $applicationEvent): IApplicationEvent;
}
