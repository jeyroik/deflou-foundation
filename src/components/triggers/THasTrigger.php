<?php
namespace deflou\components\triggers;

use deflou\interfaces\triggers\IHasTrigger;
use deflou\interfaces\triggers\ITrigger;
use extas\interfaces\repositories\IRepository;

/**
 * Trait THasTrigger
 * 
 * @property $config
 * @method IRepository triggers()
 *
 * @package deflou\components\triggers
 * @author jeyroik@gmail.com
 */
trait THasTrigger
{
    /**
     * @return string
     */
    public function getTriggerName(): string
    {
        return $this->config[IHasTrigger::FIELD__TRIGGER_NAME] ?? '';
    }

    /**
     * @return ITrigger|null
     */
    public function getTrigger(): ?ITrigger
    {
        return $this->triggers()->one([ITrigger::FIELD__NAME => $this->getTriggerName()]);
    }

    /**
     * @param string $triggerName
     * @return $this
     */
    public function setTriggerName(string $triggerName)
    {
        $this->config[IHasTrigger::FIELD__TRIGGER_NAME] = $triggerName;
        
        return $this;
    }
}
