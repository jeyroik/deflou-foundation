<?php
namespace deflou\interfaces;

use extas\interfaces\IItem;

/**
 * Interface IDeflou
 *
 * @package deflou\interfaces
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IDeflou extends IItem
{
    public const INPUT__SOURCE = '__source__';

    /**
     * @param IInput $input
     * @return IOutput
     */
    public function dispatchEvent(IInput $input): IOutput;
}
