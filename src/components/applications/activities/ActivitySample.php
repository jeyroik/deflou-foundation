<?php
namespace deflou\components\applications\activities;

use deflou\interfaces\applications\activities\IActivitySample;
use extas\components\players\THasPlayer;
use extas\components\samples\Sample;
use extas\components\THasType;

/**
 * Class ActivitySample
 *
 * @package deflou\components\applications\activities
 * @author jeyroik@gmail.com
 */
class ActivitySample extends Sample implements IActivitySample
{
    use THasPlayer;
    use THasType;
    use THasActivityFields;

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'deflou.activity.sample';
    }
}
