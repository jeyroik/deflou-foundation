<?php
namespace deflou\components\triggers;

use deflou\interfaces\triggers\ITrigger;
use extas\components\samples\THasSample;
use extas\components\THasState;

/**
 * Class Trigger
 *
 * @package deflou\components\triggers
 * @author jeyroik@gmail.com
 */
class Trigger extends TriggerSample implements ITrigger
{
    use THasSample;
    use THasState;

    /**
     * @return int
     */
    public function getExecutionCount(): int
    {
        return $this->config[static::FIELD__EXECUTION_COUNT] ?? 0;
    }

    /**
     * @return int
     */
    public function getExecutionLastTime(): int
    {
        return $this->config[static::FIELD__EXECUTION_LAST_TIME] ?? 0;
    }

    /**
     * @param int $executionCount
     * @return $this
     */
    public function setExecutionCount(int $executionCount)
    {
        $this->config[static::FIELD__EXECUTION_COUNT] = $executionCount;

        return $this;
    }

    /**
     * @param int $executionTime
     * @return $this
     */
    public function setExecutionLastTime(int $executionTime)
    {
        $this->config[static::FIELD__EXECUTION_LAST_TIME] = $executionTime;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou.trigger';
    }
}
