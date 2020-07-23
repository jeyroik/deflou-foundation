<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplication;
use extas\components\samples\THasSample;

/**
 * Class Application
 * 
 * @package deflou\components\applications
 * @author jeyroik@gmail.com
 */
class Application extends ApplicationSample implements IApplication
{
    use THasSample;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou.application';
    }
}
