<?php
namespace deflou\interfaces\applications\activities;

/**
 * Interface IHasAction
 *
 * @package deflou\interfaces\applications\activities
 * @author jeyroik@gmail.com
 */
interface IHasAction
{
    public const FIELD__ACTION_NAME = 'action_name';

    /**
     * @return string
     */
    public function getActionName(): string;

    /**
     * @return IActivity|null
     */
    public function getAction(): ?IActivity;

    /**
     * @param string $actionName
     * @return $this
     */
    public function setActionName(string $actionName);
}
