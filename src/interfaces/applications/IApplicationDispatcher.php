<?php
namespace deflou\interfaces\applications;

use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;

/**
 * Interface IApplicationDispatcher
 *
 * @package deflou\interfaces\applications
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IApplicationDispatcher extends IItem, IHasName
{
    public const SUBJECT = 'deflou.application.';

    public const FIELD__APPLICATION_EVENT = 'event';
    public const FIELD__APPLICATION_ACTION = 'ACTION';

    /**
     * @return IApplicationEvent
     */
    public function getApplicationEvent(): IApplicationEvent;

    /**
     * @return IApplicationAction
     */
    public function getApplicationAction(): IApplicationAction;
}
