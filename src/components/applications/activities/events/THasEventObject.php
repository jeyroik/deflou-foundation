<?php
namespace deflou\components\applications\activities\events;

use deflou\interfaces\applications\activities\events\IHasEventObject;
use deflou\interfaces\applications\activities\IActivity;
use extas\components\exceptions\MissedOrUnknown;

/**
 * Trait THasEventObject
 *
 * @property array $config
 *
 * @package deflou\components\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasEventObject
{
    /**
     * @return IActivity
     * @throws MissedOrUnknown
     */
    public function getEvent(): IActivity
    {
        $event = $this->config[IHasEventObject::FIELD__EVENT] ?? null;

        if (!$event) {
            throw new MissedOrUnknown('event');
        }

        return $event;
    }
}
