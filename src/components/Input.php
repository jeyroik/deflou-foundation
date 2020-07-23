<?php
namespace deflou\components;

use deflou\interfaces\IInput;
use extas\components\Item;

/**
 * Class Input
 *
 * @package deflou\components
 * @author jeyroik <jeyroik@gmail.com>
 */
class Input extends Item implements IInput
{
    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
