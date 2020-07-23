<?php
namespace deflou\interfaces\triggers\actions;

use deflou\interfaces\applications\IHasApplication;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHasId;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use extas\interfaces\samples\IHasSample;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IApplicationAction
 *
 * parameters.source - source parameters from a trigger
 * parameters.artifacts - operated parameters
 *
 * @package deflou\interfaces\triggers\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IApplicationAction extends
    IItem,
    IHasName,
    IHasApplication,
    IHasSample,
    IHasSampleParameters,
    IHasId,
    IHasCreatedAt
{
    public const SUBJECT = 'deflou.trigger.application.action';

    public const FIELD__APPLICATION_SAMPLE_NAME = 'application_sample_name';

    public const PARAM__SOURCE = 'source';
    public const PARAM__ARTIFACTS = 'artifacts';

    /**
     * @return string
     */
    public function getApplicationSampleName(): string;
}
