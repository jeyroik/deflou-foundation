<?php
namespace deflou\components\triggers;

use deflou\interfaces\triggers\ITriggerResponse;
use extas\components\Item;
use extas\components\players\THasPlayer;
use extas\components\THasCreatedAt;
use extas\components\THasId;
use extas\interfaces\repositories\IRepository;

/**
 * Class TriggerResponse
 *
 * @method IRepository activities()
 * @method IRepository applications()
 * @method IRepository activitiesSamples()
 * @method IRepository applicationsSamples()
 *
 * @package deflou\components\triggers
 * @author jeyroik@gmail.com
 */
class TriggerResponse extends Item implements ITriggerResponse
{
    use THasCreatedAt;
    use THasPlayer;
    use THasId;
    use THasTrigger;

    /**
     * @return string
     */
    public function getEventId(): string
    {
        return $this->config[static::FIELD__EVENT_ID] ?? '';
    }

    /**
     * @return string
     */
    public function getActionId(): string
    {
        return $this->config[static::FIELD__ACTION_ID] ?? '';
    }

    /**
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->config[static::FIELD__RESPONSE_BODY] ?? '';
    }

    /**
     * @return int
     */
    public function getResponseStatus(): int
    {
        return $this->config[static::FIELD__RESPONSE_STATUS] ?? 0;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->config[static::FIELD__IS_SUCCESS] ?? false;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
