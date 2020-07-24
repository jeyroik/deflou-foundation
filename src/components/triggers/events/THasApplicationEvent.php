<?php
namespace deflou\components\triggers\events;

use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\events\IHasApplicationEvent;

/**
 * Class THasApplicationEvent
 *
 * @property array $config
 *
 * @package deflou\components\triggers\events
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasApplicationEvent
{
    /**
     * @return IApplicationEvent
     */
    public function getApplicationEvent(): IApplicationEvent
    {
        return $this->config[IHasApplicationEvent::FIELD__APPLICATION_EVENT];
    }
}
