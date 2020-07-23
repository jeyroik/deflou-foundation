<?php
namespace deflou\interfaces\applications\activities\events;

use deflou\interfaces\applications\activities\IActivity;

/**
 * Interface IHasEventObject
 *
 * @package deflou\interfaces\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasEventObject
{
    public const FIELD__EVENT = 'event';

    /**
     * @return IActivity
     */
    public function getEvent(): IActivity;
}
