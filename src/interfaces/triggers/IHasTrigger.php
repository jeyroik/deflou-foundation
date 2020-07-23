<?php
namespace deflou\interfaces\triggers;

/**
 * Interface IHasTrigger
 *
 * @package deflou\interfaces\triggers
 * @author jeyroik@gmail.com
 */
interface IHasTrigger
{
    public const FIELD__TRIGGER_NAME = 'trigger_name';

    /**
     * @return string
     */
    public function getTriggerName(): string;

    /**
     * @return ITrigger|null
     */
    public function getTrigger(): ?ITrigger;

    /**
     * @param string $triggerName
     * @return $this
     */
    public function setTriggerName(string $triggerName);
}
