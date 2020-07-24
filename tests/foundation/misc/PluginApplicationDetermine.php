<?php
namespace tests\foundation\misc;

use deflou\components\applications\Application;
use deflou\interfaces\servers\requests\IApplicationRequest;
use deflou\interfaces\stages\IStageApplicationDetermine;
use extas\components\plugins\Plugin;

/**
 * Class PluginApplicationDetermine
 *
 * @package tests\foundation\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginApplicationDetermine extends Plugin implements IStageApplicationDetermine
{
    /**
     * @param IApplicationRequest $request
     * @return IApplicationRequest
     */
    public function __invoke(IApplicationRequest $request): IApplicationRequest
    {
        $request->addParameterByValue($request::PARAM__EVENT_APPLICATION, new Application([
            Application::FIELD__NAME => 'test.app',
            Application::FIELD__SAMPLE_NAME => 'test.app.sample',
            Application::FIELD__CLASS => MiscApplication::class
        ]));

        return $request;
    }
}
