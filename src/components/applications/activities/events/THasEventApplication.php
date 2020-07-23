<?php
namespace deflou\components\applications\activities\events;

use deflou\interfaces\applications\activities\events\IHasEventApplication;
use deflou\interfaces\applications\IApplication;
use extas\components\exceptions\MissedOrUnknown;

/**
 * Trait THasEventApplication
 *
 * @property array $config
 *
 * @package deflou\components\applications\activities\events
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasEventApplication
{
    /**
     * @return IApplication
     * @throws MissedOrUnknown
     */
    public function getEventApplication(): IApplication
    {
        $app = $this->config[IHasEventApplication::FIELD__EVENT_APPLICATION] ?? null;

        if (!$app) {
            throw new MissedOrUnknown('event application');
        }

        return $app;
    }
}
