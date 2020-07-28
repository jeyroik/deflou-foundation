<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\triggers\actions\IApplicationActionResponse;
use deflou\interfaces\triggers\actions\IHasApplicationAction;
use deflou\interfaces\triggers\events\IHasApplicationEvent;
use deflou\interfaces\triggers\IHasTriggerObject;

/**
 * Interface IStageAfterActionRun
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageAfterActionRun extends IHasTriggerObject, IHasApplicationEvent, IHasApplicationAction
{
    public const NAME = 'deflou.after.action.run';

    /**
     * @param IApplicationActionResponse $response
     * @return IApplicationActionResponse
     */
    public function __invoke(IApplicationActionResponse $response): IApplicationActionResponse;
}
