<?php
namespace deflou\components\servers\requests;

use deflou\interfaces\servers\requests\IApplicationRequest;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;

/**
 * Class ApplicationRequest
 *
 * @package deflou\components\servers\requests
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationRequest extends Item implements IApplicationRequest
{
    use THasSampleParameters;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
