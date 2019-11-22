<?php

//use humhub\modules\content\widgets\WallEntryControls;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\widgets\WallEntryLinks;

return [
    'id' => 'sharebetween',
    'class' => 'humhub\modules\sharebetween\Module',
    'namespace' => 'humhub\modules\sharebetween',
    'events' => [
        ['class' => ContentActiveRecord::className(), 'event' => ContentActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\sharebetween\Events', 'onContentDelete']],
//        ['class' => WallEntryControls::className(), 'event' => WallEntryControls::EVENT_INIT, 'callback' => ['humhub\modules\sharebetween\Events', 'onWallEntryControlsInit']],
    	['class' => WallEntryLinks::className(), 'event' => WallEntryLinks::EVENT_INIT, 'callback' => array('humhub\modules\sharebetween\Events', 'onWallEntryLinksInit')],
     ],
];
