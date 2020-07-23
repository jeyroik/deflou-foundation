<?php
namespace deflou\interfaces\triggers;

use deflou\interfaces\applications\activities\IHasAction;
use deflou\interfaces\applications\activities\IHasEvent;
use extas\interfaces\conditions\IConditionParameter;
use extas\interfaces\IHasTags;
use extas\interfaces\players\IHasPlayer;
use extas\interfaces\samples\ISample;
use extas\interfaces\samples\parameters\ISampleParameter;

/**
 * Interface ITriggerSample
 *
 * @package deflou\interfaces\triggers
 * @author jeyroik@gmail.com
 */
interface ITriggerSample extends ISample, IHasPlayer, IHasEvent, IHasAction, IHasTags
{
    public const FIELD__EVENT_PARAMETERS = 'event_parameters';
    public const FIELD__ACTION_PARAMETERS = 'action_parameters';

    /**
     * @param string $name
     * @return ISampleParameter|null
     */
    public function getEventParameter(string $name): ?ISampleParameter;

    /**
     * @return IConditionParameter[]
     */
    public function getEventParameters(): array;

    /**
     * @return array
     */
    public function getEventParametersOptions(): array;

    /**
     * @param string $name
     * @return ISampleParameter|null
     */
    public function getActionParameter(string $name): ?ISampleParameter;

    /**
     * @return ISampleParameter[]
     */
    public function getActionParameters(): array;

    /**
     * @return array
     */
    public function getActionParametersOptions(): array;

    /**
     * @param IConditionParameter[] $parameters
     * @return $this
     */
    public function setEventParameters(array $parameters);

    /**
     * @param array $parametersOptions
     * @return $this
     */
    public function setEventParametersOptions(array $parametersOptions);

    /**
     * @param ISampleParameter[] $parameters
     * @return $this
     */
    public function setActionParameters(array $parameters);

    /**
     * @param array $parametersOptions
     * @return $this
     */
    public function setActionParametersOptions(array $parametersOptions);
}
