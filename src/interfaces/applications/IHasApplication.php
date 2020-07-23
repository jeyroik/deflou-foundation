<?php
namespace deflou\interfaces\applications;

/**
 * Interface IHasApplication
 *
 * @package deflou\interfaces\applications
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IHasApplication
{
    public const FIELD__APPLICATION_NAME = 'application_name';

    /**
     * @return string
     */
    public function getApplicationName(): string;

    /**
     * @return IApplication|null
     */
    public function getApplication(): ?IApplication;

    /**
     * @param string $name
     * @return $this
     */
    public function setApplicationName(string $name);
}
