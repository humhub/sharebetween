<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\notifications;

use humhub\modules\content\notifications\ContentCreated;
use humhub\modules\sharebetween\models\Share;
use Yii;
use yii\bootstrap\Html;

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
        return Yii::t('SharebetweenModule.base', '{user} shared something interesting from Space {space}.', [
            'user' => Html::tag('strong', Html::encode($this->originator->displayName)),
            'space' => Html::tag('strong', Html::encode($this->source->sharedContent->container->displayName)),
        ]);
    }
}
