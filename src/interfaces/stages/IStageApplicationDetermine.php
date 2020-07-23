<?php
namespace deflou\interfaces\stages;

use deflou\interfaces\servers\requests\IApplicationRequest;

/**
 * Interface IStageApplicationDetermine
 *
 * @package deflou\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageApplicationDetermine
{
    public const NAME = 'deflou.application.determine';

    /**
     * @param IApplicationRequest $request
     * @return IApplicationRequest
     */
    public function __invoke(IApplicationRequest $request): IApplicationRequest;
}
