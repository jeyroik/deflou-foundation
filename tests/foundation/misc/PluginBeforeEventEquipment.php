<?php
namespace tests\foundation\misc;

use deflou\interfaces\stages\IStageBeforeEventEquipment;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\components\plugins\Plugin;

/**
 * Class PluginBeforeEventEquipment
 *
 * @package tests\foundation\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginBeforeEventEquipment extends Plugin implements IStageBeforeEventEquipment
{
    /**
     * @param IApplicationEvent $applicationEvent
     * @return IApplicationEvent
     */
    public function __invoke(IApplicationEvent $applicationEvent): IApplicationEvent
    {
        $applicationEvent->addParameterByValue('before_equipment', true);

        return $applicationEvent;
    }
}
