<?php
namespace deflou\interfaces\applications\activities\events;

use extas\interfaces\IItem;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IEventCall
 *
 * @package deflou\interfaces\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IEventCall extends IItem, IHasSampleParameters, IHasEventApplication, IHasEventObject
{
    public const SUBJECT = 'deflou.event.call';
}
