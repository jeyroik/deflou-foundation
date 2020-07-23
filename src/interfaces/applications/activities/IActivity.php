<?php
namespace deflou\interfaces\applications\activities;

use deflou\interfaces\applications\IHasApplication;
use extas\interfaces\samples\IHasSample;

/**
 * Interface IActivity
 *
 * @package deflou\interfaces\applications\activities
 * @author jeyroik@gmail.com
 */
interface IActivity extends IActivitySample, IHasSample, IHasApplication
{
    public const TYPE__EVENT = 'event';
    public const TYPE__ACTION = 'action';
}
