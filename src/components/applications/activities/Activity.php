<?php
namespace deflou\components\applications\activities;

use deflou\components\applications\THasApplication;
use deflou\interfaces\applications\activities\IActivity;
use extas\components\samples\THasSample;

/**
 * Class Activity
 *
 * @package deflou\components\applications\activities
 * @author jeyroik@gmail.com
 */
class Activity extends ActivitySample implements IActivity
{
    use THasSample;
    use THasApplication;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou.application.activity';
    }
}
