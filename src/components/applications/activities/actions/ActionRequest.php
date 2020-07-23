<?php
namespace deflou\components\applications\activities\actions;

use deflou\interfaces\applications\activities\actions\IActionRequest;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;

/**
 * Class ActionRequest
 *
 * @package deflou\components\applications\activities\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
class ActionRequest extends Item implements IActionRequest
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
