<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\servers\requests\IApplicationRequest;

/**
 * Interface IStageEventDetermine
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageEventDetermine
{
    public const NAME = 'deflou.event.determine';

    /**
     * @param IApplicationRequest $request
     * @return IApplicationRequest
     */
    public function __invoke(IApplicationRequest $request): IApplicationRequest;
}
