<?php
namespace tests\foundation\misc;

use deflou\components\applications\activities\Activity;
use deflou\interfaces\servers\requests\IApplicationRequest;
use deflou\interfaces\stages\IStageEventDetermine;
use extas\components\plugins\Plugin;

/**
 * Class PluginEventDetermine
 *
 * @package tests\foundation\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginEventDetermine extends Plugin implements IStageEventDetermine
{
    /**
     * @param IApplicationRequest $request
     * @return IApplicationRequest
     */
    public function __invoke(IApplicationRequest $request): IApplicationRequest
    {
        $request->addParameterByValue($request::PARAM__EVENT, new Activity([
            Activity::FIELD__NAME => 'test_event',
            Activity::FIELD__SAMPLE_NAME => 'testEvent'
        ]));

        return $request;
    }
}
