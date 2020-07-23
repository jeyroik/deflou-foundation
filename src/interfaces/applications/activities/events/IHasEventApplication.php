<?php
namespace deflou\interfaces\applications\activities\events;

use deflou\interfaces\applications\IApplication;

/**
 * Interface IHasEventApplication
 *
 * @package deflou\interfaces\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasEventApplication
{
    public const FIELD__EVENT_APPLICATION = 'event_application';

    /**
     * @return IApplication
     */
    public function getEventApplication(): IApplication;
}
