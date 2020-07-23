<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IDispatcherWrapper;
use extas\interfaces\IHasTags;
use extas\interfaces\IItem;
use extas\interfaces\players\IHasPlayer;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IApplicationSample
 *
 * @package deflou\interfaces\applications
 * @author jeyroik@gmail.com
 */
interface IApplicationSample extends IItem, IDispatcherWrapper, IHasSampleParameters, IHasPlayer, IHasTags
{
    public const SUBJECT = 'deflou.application.sample';
}
