<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\notifications;

use humhub\modules\content\notifications\ContentCreated;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use humhub\helpers\Html;

class SharedContentCreated extends ContentCreated
{
    /**
     * @inheritdoc
     * @var Share
     */
    public $source;

    /**
     * @inheritdoc
     */
    public function html()
    {
        $container = $this->source->sharedContent->container;

        if ($container instanceof Space) {
            return Yii::t('SharebetweenModule.base', '{user} shared something interesting from Space {space}.', [
                'user' => Html::tag('strong', Html::encode($this->originator->displayName)),
                'space' => Html::tag('strong', Html::encode($container->displayName)),
            ]);
        }

        if ($container instanceof User) {
            return Yii::t('SharebetweenModule.base', '{user} shared something interesting from user {sourceUser}.', [
                'user' => Html::tag('strong', Html::encode($this->originator->displayName)),
                'sourceUser' => Html::tag('strong', Html::encode($container->displayName)),
            ]);
        }

        return Yii::t('SharebetweenModule.base', '{user} shared something interesting from dashboard.', [
            'user' => Html::tag('strong', Html::encode($this->originator->displayName)),
        ]);
    }
}
