<?php
namespace deflou\interfaces;

use extas\interfaces\IItem;
use extas\interfaces\samples\parameters\IHasSampleParameters;

/**
 * Interface IOutput
 *
 * @package deflou\interfaces
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IOutput extends IItem, IHasSampleParameters
{
    public const SUBJECT = 'deflou.output';

    public const FIELD__MESSAGE = 'message';
    public const FIELD__CODE = 'code';

    public const PARAM__ERRORS = 'errors';

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @param string $message
     * @param int $code
     * @param array $data
     * @return IOutput
     */
    public function addError(string $message, int $code, array $data): IOutput;

    /**
     * @param string $message
     * @return IOutput
     */
    public function setMessage(string $message): IOutput;

    /**
     * @param int $code
     * @return IOutput
     */
    public function setCode(int $code): IOutput;
}
