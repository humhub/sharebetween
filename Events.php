<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween;

use humhub\modules\activity\models\Activity;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\events\ContentEvent;
use humhub\modules\notification\models\Notification;
use humhub\modules\sharebetween\models\Share;
use yii\base\BaseObject;

class Events extends BaseObject
{
    public static function onContentDelete($event)
    {
        /** @var ContentActiveRecord $record */
        $record = $event->sender;

        if ($record->content->object_model === Share::class) {
            return;
        }

        $shares = models\Share::findAll(['content_id' => $record->content->id]);
        foreach ($shares as $share) {
            $share->hardDelete();
        }
    }

    public static function onContentAfterSoftDelete(ContentEvent $event)
    {
        if ($event->content->object_model === Share::class) {
            return;
        }

        $shares = models\Share::findAll(['content_id' => $event->content->id]);
        foreach ($shares as $share) {
            $share->hardDelete();
        }
    }


    public static function onWallEntryLinksInit($event)
    {
        $stackWidget = $event->sender;

        /** @var ContentActiveRecord $record */
        $record = $event->sender->object;

        $stackWidget->addWidget(widgets\ShareLink::class, ['record' => $record]);
    }

    public static function onActivityAfterFind($event)
    {
        /* @var Activity $activity */
        $activity = $event->sender;

        if ($activity->object_model === Share::class) {
            // Switch to render specific text for the shared content activity
            $activity->class = activities\SharedContentCreated::class;
        }
    }

    public static function onNotificationAfterFind($event)
    {
        /* @var Notification $activity */
        $notification = $event->sender;

        if ($notification->source_class === Share::class) {
            // Switch to render specific text for the shared content notification
            $notification->class = notifications\SharedContentCreated::class;
        }
    }
}
