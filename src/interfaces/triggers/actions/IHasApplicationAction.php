<?php
namespace deflou\interfaces\triggers\actions;

/**
 * Interface IHasApplicationAction
 *
 * @package deflou\interfaces\triggers\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasApplicationAction
{
    public const FIELD__APPLICATION_ACTION = 'action';

    /**
     * @return IApplicationAction
     */
    public function getApplicationAction(): IApplicationAction;
}
