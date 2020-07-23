<?php
namespace deflou\components\triggers;

use deflou\components\applications\activities\THasAction;
use deflou\components\applications\activities\THasEvent;
use deflou\interfaces\triggers\ITriggerSample;
use extas\components\conditions\ConditionParameter;
use extas\components\players\THasPlayer;
use extas\components\samples\parameters\SampleParameter;
use extas\components\samples\Sample;
use extas\components\THasTags;
use extas\interfaces\conditions\IConditionParameter;
use extas\interfaces\samples\parameters\ISampleParameter;

/**
 * Class TriggerSample
 * 
 * @package deflou\components\triggers
 * @author jeyroik@gmail.com
 */
class TriggerSample extends Sample implements ITriggerSample
{
    use THasPlayer;
    use THasEvent;
    use THasAction;
    use THasTags;

    /**
     * @param string $name
     * @return ISampleParameter|null
     */
    public function getEventParameter(string $name): ?ISampleParameter
    {
        $eventParams = $this->config[static::FIELD__EVENT_PARAMETERS] ?? [];

        return isset($eventParams[$name]) ? new SampleParameter($eventParams[$name]) : null;
    }

    /**
     * @return IConditionParameter[]
     */
    public function getEventParameters(): array
    {
        $parametersOptions = $this->getEventParametersOptions();
        $parameters = [];
        
        foreach ($parametersOptions as $parameter) {
            $parameters[] = new ConditionParameter($parameter);
        }
        
        return $parameters;
    }

    /**
     * @return array
     */
    public function getEventParametersOptions(): array
    {
        return $this->config[static::FIELD__EVENT_PARAMETERS] ?? [];
    }

    /**
     * @param string $name
     * @return ISampleParameter|null
     */
    public function getActionParameter(string $name): ?ISampleParameter
    {
        $actionParams = $this->config[static::FIELD__ACTION_PARAMETERS] ?? [];

        return isset($actionParams[$name]) ? new SampleParameter($actionParams[$name]) : null;
    }

    /**
     * @return array
     */
    public function getActionParameters(): array
    {
        $parametersOptions = $this->getActionParametersOptions();
        $parameters = [];

        foreach ($parametersOptions as $parameter) {
            $parameters[] = new SampleParameter($parameter);
        }

        return $parameters;
    }

    /**
     * @return array
     */
    public function getActionParametersOptions(): array
    {
        return $this->config[static::FIELD__ACTION_PARAMETERS] ?? [];
    }

    /**
     * @param ISampleParameter[] $parameters
     * @return $this|TriggerSample
     */
    public function setEventParameters(array $parameters)
    {
        $parametersOptions = [];

        foreach ($parameters as $parameter) {
            $parametersOptions[$parameter->getName()] = $parameter->__toArray();
        }

        return $this->setEventParametersOptions($parametersOptions);
    }

    /**
     * @param array $parametersOptions
     * @return $this
     */
    public function setEventParametersOptions(array $parametersOptions)
    {
        $this->config[static::FIELD__EVENT_PARAMETERS] = $parametersOptions;
        
        return $this;
    }

    /**
     * @param ISampleParameter[] $parameters
     * @return $this|TriggerSample
     */
    public function setActionParameters(array $parameters)
    {
        $parametersOptions = [];
        
        foreach ($parameters as $parameter) {
            $parametersOptions[$parameter->getName()] = $parameter->__toArray();
        }
        
        return $this->setActionParametersOptions($parametersOptions);
    }

    /**
     * @param array $parametersOptions
     * @return $this
     */
    public function setActionParametersOptions(array $parametersOptions)
    {
        $this->config[static::FIELD__ACTION_PARAMETERS] = $parametersOptions;
        
        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou.trigger.sample';
    }
}
