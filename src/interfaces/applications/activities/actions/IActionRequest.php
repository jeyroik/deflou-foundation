<?php
namespace deflou\interfaces\applications\activities\actions;

use extas\interfaces\IItem;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IActionRequest
 *
 * @package deflou\interfaces\applications\activities\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IActionRequest extends IItem, IHasSampleParameters
{
    public const SUBJECT = 'deflou.action.request';
}
