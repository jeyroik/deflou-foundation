<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplicationSample;
use extas\components\Item;
use extas\components\players\THasPlayer;
use extas\components\samples\parameters\THasSampleParameters;
use extas\components\TDispatcherWrapper;
use extas\components\THasTags;

/**
 * Class ApplicationSample
 * 
 * @package deflou\components\applications
 * @author jeyroik@gmail.com
 */
class ApplicationSample extends Item implements IApplicationSample
{
    use THasPlayer;
    use THasTags;
    use TDispatcherWrapper;
    use THasSampleParameters;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
