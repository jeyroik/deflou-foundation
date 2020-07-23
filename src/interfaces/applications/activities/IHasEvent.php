<?php
namespace deflou\interfaces\applications\activities;

/**
 * Interface IHasEvent
 * 
 * @package deflou\interfaces\applications\activities
 * @author jeyroik@gmail.com
 */
interface IHasEvent
{
    public const FIELD__EVENT_NAME = 'event_name';

    /**
     * @return string
     */
    public function getEventName(): string;

    /**
     * @return IActivity|null
     */
    public function getEvent(): ?IActivity;

    /**
     * @param string $eventName
     * @return $this
     */
    public function setEventName(string $eventName);
}
