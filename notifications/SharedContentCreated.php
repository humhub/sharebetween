<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\notifications;

use humhub\modules\content\notifications\ContentCreatedNotification;
use humhub\modules\notification\components\BaseNotification;
use humhub\modules\notification\components\Grouping;
use humhub\modules\notification\components\MessageParam;
use humhub\modules\notification\components\NotificationCategory;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;

/**
 * Renders the {@see ContentCreatedNotification} about a {@see Share} with the sentence of the module.
 *
 * The core sends the notification of a created content as `ContentCreatedNotification`; the module
 * switches the class of such a record about a Share when it is loaded, see
 * {@see \humhub\modules\sharebetween\Events::onNotificationAfterFind()}.
 *
 * @since 1.0
 */
final class SharedContentCreated extends BaseNotification
{
    /**
     * @inheritdoc
     */
    public static function category(): NotificationCategory
    {
        return NotificationCategory::content();
    }

    /**
     * @inheritdoc
     */
    public static function grouping(): ?Grouping
    {
        return ContentCreatedNotification::grouping();
    }

    /**
     * @inheritdoc
     */
    protected function getMessage(array $params): string
    {
        if ($this->groupCount > 1) {
            return Yii::t('SharebetweenModule.base', '{displayName} shared {groupCount} new entries.', $params);
        }

        $container = $this->getSharedContainer();

        if ($container instanceof Space) {
            return Yii::t('SharebetweenModule.base', '{user} shared something interesting from Space {space}.', $params);
        }

        if ($container instanceof User) {
            return Yii::t('SharebetweenModule.base', '{user} shared something interesting from user {sourceUser}.', $params);
        }

        return Yii::t('SharebetweenModule.base', '{user} shared something interesting from dashboard.', $params);
    }

    /**
     * @inheritdoc
     */
    protected function getMessageParams(): array
    {
        $container = $this->getSharedContainer();
        $name = MessageParam::emphasis($container?->displayName ?? '');

        return [
            'user' => $this->originator !== null ? MessageParam::user($this->originator) : '',
            'space' => $name,
            'sourceUser' => $name,
        ];
    }

    /**
     * @return Space|User|null the container the shared content comes from
     */
    private function getSharedContainer()
    {
        $share = $this->getSubjectRecord();

        return $share instanceof Share ? $share->sharedContent?->container : null;
    }
}
