<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IHasApplication;
use extas\interfaces\repositories\IRepository;

/**
 * Trait THasApplication
 *
 * @property $config
 * @method IRepository applications()
 *
 * @package deflou\components\applications
 * @author jeyroik <jeyroik@gmail.com>
 */
trait THasApplication
{
    /**
     * @return string
     */
    public function getApplicationName(): string
    {
        return $this->config[IHasApplication::FIELD__APPLICATION_NAME] ?? '';
    }

    /**
     * @return IApplication|null
     */
    public function getApplication(): ?IApplication
    {
        return $this->applications()->one([IApplication::FIELD__NAME => $this->getApplicationName()]);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setApplicationName(string $name)
    {
        $this->config[IHasApplication::FIELD__APPLICATION_NAME] = $name;

        return $this;
    }
}
