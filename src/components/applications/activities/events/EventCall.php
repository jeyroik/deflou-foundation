<?php
namespace deflou\components\applications\activities\events;

use deflou\interfaces\applications\activities\events\IEventCall;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;

/**
 * Class EventCall
 *
 * @package deflou\components\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
class EventCall extends Item implements IEventCall
{
    use THasSampleParameters;
    use THasEventApplication;
    use THasEventObject;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
