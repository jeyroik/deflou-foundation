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

    public function getMessage(): string
    {
        // TODO: Implement getMessage() method.
    }

    public function getCode(): int
    {
        // TODO: Implement getCode() method.
    }

    public function hasErrors(): bool
    {
        // TODO: Implement hasErrors() method.
    }

    public function addError(string $message, int $code, array $data): IOutput
    {
        // TODO: Implement addError() method.
    }

    public function setMessage(string $message): IOutput
    {
        // TODO: Implement setMessage() method.
    }

    public function setCode(int $code): IOutput
    {
        // TODO: Implement setCode() method.
    }

    protected function getSubjectForExtension(): string
    {
        // TODO: Implement getSubjectForExtension() method.
    }
}
