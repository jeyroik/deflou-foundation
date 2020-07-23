<?php
namespace deflou\components\triggers;

use deflou\interfaces\triggers\ITriggerStateHistory;
use extas\components\Item;
use extas\components\players\THasPlayer;
use extas\components\THasCreatedAt;
use extas\components\THasId;

/**
 * Class TriggerStateHistory
 *
 * @package deflou\components\triggers
 * @author jeyroik@gmail.com
 */
class TriggerStateHistory extends Item implements ITriggerStateHistory
{
    use THasId;
    use THasPlayer;
    use THasTrigger;
    use THasCreatedAt;

    /**
     * @return string
     */
    public function getStateFrom(): string
    {
        return $this->config[static::FIELD__STATE_FROM] ?? '';
    }

    /**
     * @return string
     */
    public function getStateTo(): string
    {
        return $this->config[static::FIELD__STATE_TO] ?? '';
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setStateFrom(string $state)
    {
        $this->config[static::FIELD__STATE_FROM] = $state;

        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setStateTo(string $state)
    {
        $this->config[static::FIELD__STATE_TO] = $state;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
