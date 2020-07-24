<?php
namespace deflou\components\triggers\actions;

use deflou\interfaces\triggers\actions\IApplicationActionResponse;
use extas\components\Item;

/**
 * Class ApplicationActionResponse
 *
 * @package deflou\components\triggers\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationActionResponse extends Item implements IApplicationActionResponse
{
    /**
     * @return string
     */
    public function getActionId(): string
    {
        return $this->config[static::FIELD__APPLICATION_ACTION_ID] ?? '';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->config[static::FIELD__BODY] ?? '';
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->config[static::FIELD__STATUS] ?? 0;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
