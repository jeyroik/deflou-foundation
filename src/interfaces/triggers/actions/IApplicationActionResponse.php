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
    public const NAME = 'deflou.application.action.response';

    public const FIELD__APPLICATION_ACTION_ID = 'action_id';
    public const FIELD__RESPONSE_STATUS = 'response_status';
    public const FIELD__RESPONSE_BODY = 'response_body';

    /**
     * @return string
     */
    public function getActionId(): string;

    /**
     * @return int
     */
    public function getResponseStatus(): int;

    /**
     * @return string
     */
    public function getResponseBody(): string;
}
