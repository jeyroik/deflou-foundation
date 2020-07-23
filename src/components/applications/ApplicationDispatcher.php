<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplicationDispatcher;
use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\events\IApplicationEvent;
use extas\components\Item;
use extas\components\THasName;

/**
 * Class ApplicationDispatcher
 *
 * @package deflou\components\applications
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationDispatcher extends Item implements IApplicationDispatcher
{
    use THasName;

    /**
     * @return IApplicationEvent
     */
    public function getApplicationEvent(): IApplicationEvent
    {
        return $this->config[static::FIELD__APPLICATION_EVENT];
    }

    /**
     * @return IApplicationAction
     */
    public function getApplicationAction(): IApplicationAction
    {
        return $this->config[static::FIELD__APPLICATION_ACTION];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT . $this->getName();
    }
}
