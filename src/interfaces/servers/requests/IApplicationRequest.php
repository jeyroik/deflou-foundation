<?php
namespace deflou\interfaces\servers\requests;

use extas\interfaces\http\IHasHttpIO;
use extas\interfaces\IItem;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IApplicationRequest
 *
 * @package deflou\interfaces\servers\requests
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IApplicationRequest extends IItem, IHasSampleParameters
{
    public const SUBJECT = 'deflou.application.request';

    public const PARAM__EVENT = 'event';
    public const PARAM__EVENT_APPLICATION = 'event_application';
    public const PARAM__DATA = 'data';
}
