<?php
namespace deflou\components\triggers\events;

use deflou\components\applications\THasApplication;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;
use extas\components\samples\THasSample;
use extas\components\THasCreatedAt;
use extas\components\THasId;
use extas\components\THasName;

/**
 * Class ApplicationEvent
 *
 * @package deflou\components\triggers\events
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationEvent extends Item implements IApplicationEvent
{
    use THasId;
    use THasName;
    use THasSample;
    use THasSampleParameters;
    use THasCreatedAt;
    use THasApplication;

    /**
     * @return string
     */
    public function getApplicationSampleName(): string
    {
        return $this->config[static::FIELD__APPLICATION_SAMPLE_NAME] ?? '';
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->config[static::FIELD__SOURCE] ?? '';
    }

    /**
     * @return array
     */
    public function getSourceParameters(): array
    {
        return $this->getParameterValue(static::PARAM__SOURCE, []);
    }

    /**
     * @return array
     */
    public function getArtifactsParameters(): array
    {
        return $this->getParameterValue(static::PARAM__ARTIFACTS, []);
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
