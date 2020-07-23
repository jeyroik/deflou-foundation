<?php
namespace deflou\interfaces\applications\activities;

use extas\interfaces\fields\IHasFields;
use extas\interfaces\IHasType;
use extas\interfaces\players\IHasPlayer;
use extas\interfaces\samples\ISample;

/**
 * Interface IActivitySample
 *
 * @package deflou\interfaces\applications\activities
 * @author jeyroik@gmail.com
 */
interface IActivitySample extends ISample, IHasPlayer, IHasType, IHasFields
{
}
