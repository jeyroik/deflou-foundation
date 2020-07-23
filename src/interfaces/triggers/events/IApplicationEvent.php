<?php
namespace deflou\interfaces\triggers\events;

use deflou\interfaces\applications\IHasApplication;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHasId;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use extas\interfaces\samples\IHasSample;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IApplicationEvent
 *
 * parameters.source - source parameters from an application
 * parameters.artifacts - operated parameters
 *
 * @package deflou\interfaces\triggers\events
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IApplicationEvent extends
    IItem,
    IHasName,
    IHasApplication,
    IHasSample,
    IHasSampleParameters,
    IHasId,
    IHasCreatedAt
{
    public const SUBJECT = 'deflou.trigger.application.event';

    public const FIELD__APPLICATION_SAMPLE_NAME = 'application_sample_name';
    public const FIELD__SOURCE = 'source';

    public const PARAM__SOURCE = 'source';
    public const PARAM__ARTIFACTS = 'artifacts';

    /**
     * @return string
     */
    public function getApplicationSampleName(): string;

    /**
     * @return string
     */
    public function getSource(): string;

    /**
     * @return array
     */
    public function getSourceParameters(): array;

    /**
     * @return array
     */
    public function getArtifactsParameters(): array;
}
