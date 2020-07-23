<?php
namespace deflou\components\triggers\actions;

use deflou\components\applications\THasApplication;
use deflou\interfaces\triggers\actions\IApplicationAction;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;
use extas\components\samples\THasSample;
use extas\components\THasCreatedAt;
use extas\components\THasId;
use extas\components\THasName;

/**
 * Class ApplicationAction
 *
 * @package deflou\components\triggers\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationAction extends Item implements IApplicationAction
{
    use THasId;
    use THasName;
    use THasSample;
    use THasApplication;
    use THasCreatedAt;
    use THasSampleParameters;

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
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
