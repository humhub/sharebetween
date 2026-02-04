<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\activities;

use humhub\helpers\Html;
use humhub\modules\activity\components\BaseContentActivity;
use humhub\modules\activity\interfaces\ConfigurableActivityInterface;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;

class SharedContentActivity extends BaseContentActivity implements ConfigurableActivityInterface
{
    public static function getTitle(): string
    {
        return Yii::t('SharebetweenModule.base', 'Share Content');
    }

    public static function getDescription(): string
    {
        return Yii::t('SharebetweenModule.base', 'Whenever content (e.g. a post) is shared by a user.');
    }

    protected function getMessage(array $params): string
    {
        /* @var $share Share */
        $share = $this->contentActiveRecord;
        $container = $share->getContentRecord()?->content?->container;

        if ($container instanceof Space) {
            return Yii::t('SharebetweenModule.base', '{displayName} shared something interesting from Space {space}.', array_merge($params, [
                'space' => Html::strong(Html::encode($container->displayName)),
            ]));
        } elseif ($container instanceof User) {
            return Yii::t('SharebetweenModule.base', '{displayName} shared something interesting from user {sourceUser}.', array_merge($params, [
                'sourceUser' => Html::strong(Html::encode($container->displayName)),
            ]));
        }

        return Yii::t('SharebetweenModule.base', '{displayName} shared something interesting from dashboard.', $params);
    }
}
