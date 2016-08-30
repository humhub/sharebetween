<?php

namespace humhub\modules\sharebetween\widgets;

use Yii;

/**
 * Shows a Task Wall Entry
 */
class StreamEntry extends \humhub\modules\content\widgets\WallEntry
{

    public $wallEntryLayout = "@sharebetween/widgets/views/wallEntry.php";

    public function run()
    {
        return $this->render('streamEntry', ['share' => $this->contentObject]);
    }

}
