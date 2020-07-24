<?php
namespace deflou\components;

use deflou\interfaces\IOutput;
use extas\components\Item;
use extas\components\samples\parameters\THasSampleParameters;

/**
 * Class Output
 *
 * @package deflou\components
 * @author jeyroik <jeyroik@gmail.com>
 */
class Output extends Item implements IOutput
{
    use THasSampleParameters;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->config[static::FIELD__MESSAGE] ?? '';
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->config[static::FIELD__CODE] ?? 0;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->hasParameter(static::PARAM__ERRORS);
    }

    /**
     * @param string $message
     * @param int $code
     * @param array $data
     * @return $this|IOutput
     * @throws \Exception
     */
    public function addError(string $message, int $code, array $data): IOutput
    {
        $this->setMessage($message)->setCode($code);
        if (!$this->hasParameter(static::PARAM__ERRORS)) {
            $this->addParameterByValue(static::PARAM__ERRORS, []);
        }

        $errors = $this->getParameterValue(static::PARAM__ERRORS);
        $errors[] = [
            static::FIELD__MESSAGE => $message,
            static::FIELD__CODE => $code,
            'data' => $data
        ];
        $this->setParameterValue(static::PARAM__ERRORS, $errors);

        return $this;
    }

    /**
     * @param string $message
     * @return $this|IOutput
     */
    public function setMessage(string $message): IOutput
    {
        $this->config[static::FIELD__MESSAGE] = $message;

        return $this;
    }

    /**
     * @param int $code
     * @return $this|IOutput
     */
    public function setCode(int $code): IOutput
    {
        $this->config[static::FIELD__CODE] = $code;

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
