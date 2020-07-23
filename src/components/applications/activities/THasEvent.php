<?php
namespace deflou\components\applications\activities;

use deflou\interfaces\applications\activities\IActivity;
use deflou\interfaces\applications\activities\IHasEvent;
use extas\components\exceptions\MissedOrUnknown;
use extas\interfaces\repositories\IRepository;

/**
 * Trait THasEvent
 * 
 * @property $config
 * @method IRepository activities()
 * 
 * @package deflou\components\applications\activities
 * @author jeyroik@gmail.com
 */
trait THasEvent
{
    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->config[IHasEvent::FIELD__EVENT_NAME] ?? '';
    }

    /**
     * @return IActivity|null
     */
    public function getEvent(): ?IActivity
    {
        return $this->activities()->one([
            IActivity::FIELD__NAME => $this->getEventName(),
            IActivity::FIELD__TYPE => IActivity::TYPE__EVENT
        ]);
    }

    /**
     * @param string $eventName
     * @return $this
     */
    public function setEventName(string $eventName)
    {
        $this->config[IHasEvent::FIELD__EVENT_NAME] = $eventName;
        
        return $this;
    }
}
