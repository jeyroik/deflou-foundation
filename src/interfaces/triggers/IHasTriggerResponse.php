<?php
namespace deflou\interfaces\triggers;

/**
 * Interface IHasTriggerResponse
 *
 * @package deflou\interfaces\triggers
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasTriggerResponse
{
    public const FIELD__STATUS = 'status';
    public const FIELD__BODY = 'body';

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @param mixed $body
     * @return $this
     */
    public function setBody($body);
}
