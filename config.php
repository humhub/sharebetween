<?php

use humhub\modules\activity\models\Activity;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\widgets\WallEntryLinks;
use humhub\modules\notification\models\Notification;
use humhub\modules\sharebetween\Events;

return [
    'id' => 'sharebetween',
    'class' => 'humhub\modules\sharebetween\Module',
    'namespace' => 'humhub\modules\sharebetween',
    'events' => [
        [Content::class, Content::EVENT_AFTER_SOFT_DELETE, [Events::class, 'onContentAfterSoftDelete']],
        [ContentActiveRecord::class, ContentActiveRecord::EVENT_BEFORE_DELETE, [Events::class, 'onContentDelete']],
        [WallEntryLinks::class, WallEntryLinks::EVENT_INIT, [Events::class, 'onWallEntryLinksInit']],
        [Activity::class, Activity::EVENT_AFTER_FIND, [Events::class, 'onActivityAfterFind']],
        [Notification::class, Notification::EVENT_AFTER_FIND, [Events::class, 'onNotificationAfterFind']],
    ],
];
