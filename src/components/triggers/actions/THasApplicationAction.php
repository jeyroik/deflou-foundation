<?php
namespace deflou\components\triggers\actions;

use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\actions\IHasApplicationAction;

/**
 * Class THasApplicationAction
 *
 * @property array $config
 *
 * @package deflou\components\triggers\actions
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasApplicationAction
{
    /**
     * @return IApplicationAction
     */
    public function getApplicationAction(): IApplicationAction
    {
        return $this->config[IHasApplicationAction::FIELD__APPLICATION_ACTION];
    }
}
