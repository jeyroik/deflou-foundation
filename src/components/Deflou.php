<?php
namespace deflou\components;

use deflou\components\servers\requests\ApplicationRequest;
use deflou\components\triggers\actions\ApplicationAction;
use deflou\components\triggers\events\ApplicationEvent;
use deflou\interfaces\applications\activities\IActivity;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IApplicationDispatcher;
use deflou\interfaces\IDeflou;
use deflou\interfaces\IInput;
use deflou\interfaces\IOutput;
use deflou\interfaces\servers\requests\IApplicationRequest;
use deflou\interfaces\stages\IStageAfterActionRun;
use deflou\interfaces\stages\IStageAfterEventEquipment;
use deflou\interfaces\stages\IStageApplicationDetermine;
use deflou\interfaces\stages\IStageBeforeActionRun;
use deflou\interfaces\stages\IStageBeforeEventEquipment;
use deflou\interfaces\stages\IStageCollectTriggersByAppEvent;
use deflou\interfaces\stages\IStageEventDetermine;
use deflou\interfaces\triggers\actions\IApplicationAction;
use deflou\interfaces\triggers\actions\IApplicationActionResponse;
use deflou\interfaces\triggers\events\IApplicationEvent;
use deflou\interfaces\triggers\ITrigger;
use extas\components\exceptions\MissedOrUnknown;
use extas\components\Item;
use extas\interfaces\samples\parameters\ISampleParameter;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class Deflou
 *
 * @package deflou\components
 * @author jeyroik <jeyroik@gmail.com>
 */
class Deflou extends Item implements IDeflou
{
    /**
     * @param IInput $input
     * @return IOutput
     */
    public function dispatchEvent(IInput $input): IOutput
    {
        $output = new Output();
        $responses = [];

        try {
            $appRequest = new ApplicationRequest([
                ApplicationRequest::PARAM__DATA => $input->__toArray()
            ]);
            $appRequest = $this->determineEventApplication($appRequest);
            $appRequest = $this->determineEvent($appRequest);

            $appEvent = $this->createApplicationEvent($appRequest, $input);
            $appEvent = $this->equipApplicationEvent($appEvent);

            $triggers = $this->collectTriggersByAppEvent($appEvent);

            foreach($triggers as $trigger) {
                $responses[] = $this->dispatchTrigger($trigger, $appEvent);
            }

            $output = $this->runSuccessResponse($output, $responses);
        } catch (MissedOrUnknown $e) {
            $output = $this->runFailedResponse($output, $responses, $e);
        }

        return $output;
    }

    /**
     * @param IApplicationRequest $request
     * @param IInput $input
     * @return IApplicationEvent
     */
    protected function createApplicationEvent(IApplicationRequest $request, IInput $input): IApplicationEvent
    {
        /**
         * @var IActivity $event
         * @var IApplication $app
         */
        $app = $request->getParameterValue($request::PARAM__EVENT_APPLICATION);
        $event = $request->getParameterValue($request::PARAM__EVENT);

        return new ApplicationEvent([
            ApplicationEvent::FIELD__ID => Uuid::uuid6()->toString(),
            ApplicationEvent::FIELD__CREATED_AT => time(),
            ApplicationEvent::FIELD__NAME => $event->getName(),
            ApplicationEvent::FIELD__SAMPLE_NAME => $event->getSampleName(),
            ApplicationEvent::FIELD__APPLICATION_NAME => $app->getName(),
            ApplicationEvent::FIELD__APPLICATION_SAMPLE_NAME => $app->getSampleName(),
            ApplicationEvent::FIELD__PARAMETERS => [
                ApplicationEvent::PARAM__SOURCE => [
                    ISampleParameter::FIELD__NAME => ApplicationEvent::PARAM__SOURCE,
                    ISampleParameter::FIELD__VALUE => $input->__toArray()
                ]
            ],
            ApplicationEvent::FIELD__SOURCE => $input->has(static::INPUT__SOURCE)
                ? $input[static::INPUT__SOURCE]
                : 'unknown'
        ]);
    }

    /**
     * @param IApplicationRequest $appRequest
     * @return IApplicationRequest
     * @throws MissedOrUnknown
     */
    protected function determineEventApplication(IApplicationRequest $appRequest)
    {
        foreach ($this->getPluginsByStage(IStageApplicationDetermine::NAME) as $plugin) {
            /**
             * @var IStageApplicationDetermine $plugin
             */
            $appRequest = $plugin($appRequest);
        }

        if ($appRequest->hasParameter($appRequest::PARAM__EVENT_APPLICATION)) {
            return $appRequest;
        }

        throw new MissedOrUnknown('event application');
    }

    /**
     * @param IApplicationRequest $appRequest
     * @return IApplicationRequest
     * @throws MissedOrUnknown
     */
    protected function determineEvent(IApplicationRequest $appRequest)
    {
        foreach ($this->getPluginsByStage(IStageEventDetermine::NAME) as $plugin) {
            /**
             * @var IStageEventDetermine $plugin
             */
            $appRequest = $plugin($appRequest);
        }

        if ($appRequest->hasParameter($appRequest::PARAM__EVENT)) {
            return $appRequest;
        }

        throw new MissedOrUnknown('event');
    }

    /**
     * @param IApplicationEvent $appEvent
     * @return IApplicationEvent
     */
    protected function equipApplicationEvent(IApplicationEvent $appEvent): IApplicationEvent
    {
        foreach ($this->getPluginsByStage(IStageBeforeEventEquipment::NAME) as $plugin) {
            /**
             * @var IStageBeforeEventEquipment $plugin
             */
            $appEvent = $plugin($appEvent);
        }

        $eventApp = $appEvent->getApplication();
        $appEvent = $eventApp->runWithParameters(
            [
                IApplicationDispatcher::FIELD__APPLICATION_EVENT => $appEvent,
                IApplicationDispatcher::FIELD__NAME => $eventApp->getSampleName()
            ],
            $appEvent->getSampleName()
        );

        foreach ($this->getPluginsByStage(IStageAfterEventEquipment::NAME) as $plugin) {
            /**
             * @var IStageAfterEventEquipment $plugin
             */
            $appEvent = $plugin($appEvent);
        }

        return $appEvent;
    }

    /**
     * @param IApplicationEvent $appEvent
     * @return ITrigger[]
     */
    protected function collectTriggersByAppEvent(IApplicationEvent $appEvent): array
    {
        $triggers = [];

        foreach ($this->getPluginsByStage(IStageCollectTriggersByAppEvent::NAME) as $plugin) {
            /**
             * @var IStageCollectTriggersByAppEvent $plugin
             */
            $plugin($appEvent, $triggers);
        }

        return $triggers;
    }

    /**
     * @param ITrigger $trigger
     * @param IApplicationEvent $appEvent
     * @return IApplicationActionResponse
     */
    protected function dispatchTrigger(ITrigger $trigger, IApplicationEvent $appEvent): IApplicationActionResponse
    {
        $appAction = $this->createApplicationAction($trigger);

        foreach ($this->getPluginsByStage(IStageBeforeActionRun::NAME) as $plugin) {
            /**
             * @var IStageBeforeActionRun $plugin
             */
            $appAction = $plugin($appAction, $appEvent);
        }

        $actionApp = $appAction->getApplication();

        /**
         * @var IApplicationActionResponse $actionResponse
         */
        $actionResponse = $actionApp->runWithParameters(
            [
                IApplicationDispatcher::FIELD__APPLICATION_ACTION => $appAction,
                IApplicationDispatcher::FIELD__NAME => $actionApp->getSampleName()
            ],
            $appAction->getSampleName()
        );

        $pluginConfig = [
            IStageAfterActionRun::FIELD__TRIGGER => $trigger,
            IStageAfterActionRun::FIELD__APPLICATION_EVENT => $appEvent,
            IStageAfterActionRun::FIELD__APPLICATION_ACTION => $appAction
        ];

        foreach ($this->getPluginsByStage(IStageAfterActionRun::NAME, $pluginConfig) as $plugin) {
            /**
             * @var IStageAfterActionRun $plugin
             */
            $actionResponse = $plugin($actionResponse);
        }

        return $actionResponse;
    }

    /**
     * @param ITrigger $trigger
     * @return IApplicationAction
     */
    protected function createApplicationAction(ITrigger $trigger): IApplicationAction
    {
        $action = $trigger->getAction();

        return new ApplicationAction([
            ApplicationAction::FIELD__ID => Uuid::uuid6()->toString(),
            ApplicationAction::FIELD__CREATED_AT => time(),
            ApplicationAction::FIELD__NAME => $action->getName(),
            ApplicationAction::FIELD__SAMPLE_NAME => $action->getSampleName(),
            ApplicationAction::FIELD__APPLICATION_NAME => $action->getApplicationName(),
            ApplicationAction::FIELD__APPLICATION_SAMPLE_NAME => $action->getApplication()->getSampleName(),
            ApplicationAction::FIELD__PARAMETERS => [
                ApplicationAction::PARAM__SOURCE => [
                    ISampleParameter::FIELD__NAME => ApplicationAction::PARAM__SOURCE,
                    ISampleParameter::FIELD__VALUE => $trigger->getActionParametersOptions()
                ]
            ]
        ]);
    }

    /**
     * @param IOutput $output
     * @param ResponseInterface[] $responses
     * @return IOutput
     */
    protected function runSuccessResponse(IOutput $output, array $responses)
    {
        $data = [];
        foreach ($this->getPluginsByStage('deflou.trigger.response.success') as $plugin) {
            $plugin($responses, $data);
        }

        return $output->setMessage('Event dispatched')->setCode(200);
    }

    /**
     * @param IOutput $output
     * @param ResponseInterface[] $responses
     * @param MissedOrUnknown $e
     * @return IOutput
     */
    protected function runFailedResponse(IOutput $output, array $responses, MissedOrUnknown $e)
    {
        $data = [];
        foreach ($this->getPluginsByStage('deflou.trigger.response.failed') as $plugin) {
            $plugin($responses, $data);
        }

        return $output->addError($e->getMessage(), $e->getCode(), []);
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou';
    }
}
