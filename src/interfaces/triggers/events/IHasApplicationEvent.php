<?php
namespace deflou\interfaces\triggers\events;

/**
 * Interface IHasApplicationEvent
 * 
 * @package deflou\interfaces\triggers\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasApplicationEvent
{
    public const FIELD__APPLICATION_EVENT = 'event';

    /**
     * @return IApplicationEvent
     */
    public function getApplicationEvent(): IApplicationEvent;
}
