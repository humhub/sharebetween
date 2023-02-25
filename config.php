<?php

use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\widgets\WallEntryLinks;

return [
    'id' => 'sharebetween',
    'class' => 'humhub\modules\sharebetween\Module',
    'namespace' => 'humhub\modules\sharebetween',
    'events' => [
        [ContentActiveRecord::class, ContentActiveRecord::EVENT_BEFORE_DELETE, ['humhub\modules\sharebetween\Events', 'onContentDelete']],
        [WallEntryLinks::class, WallEntryLinks::EVENT_INIT, ['humhub\modules\sharebetween\Events', 'onWallEntryLinksInit']],
    ],
];
