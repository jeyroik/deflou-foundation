<?php
namespace deflou\interfaces\triggers;

use extas\interfaces\IHasState;

/**
 * Interface ITrigger
 *
 * @package deflou\interfaces\triggers
 * @author jeyroik@gmail.com
 */
interface ITrigger extends ITriggerSample, IHasState
{
    public const FIELD__EXECUTION_COUNT = 'execution_count';
    public const FIELD__EXECUTION_LAST_TIME = 'execution_time';

    /**
     * @return int
     */
    public function getExecutionCount(): int;

    /**
     * @return int
     */
    public function getExecutionLastTime(): int;

    /**
     * @param int $executionCount
     * @return $this
     */
    public function setExecutionCount(int $executionCount);

    /**
     * @param int $executionTime
     * @return $this
     */
    public function setExecutionLastTime(int $executionTime);
}
