<?php
namespace deflou\interfaces\triggers\actions;

use extas\interfaces\IItem;

/**
 * Interface IApplicationActionResponse
 *
 * @package deflou\interfaces\triggers\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IApplicationActionResponse extends IItem
{
    public const SUBJECT = 'deflou.application.action.response';

    public const FIELD__APPLICATION_ACTION_ID = 'action_id';
    public const FIELD__STATUS = 'status';
    public const FIELD__BODY = 'body';

    /**
     * @return string
     */
    public function getActionId(): string;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return string
     */
    public function getBody(): string;
}
