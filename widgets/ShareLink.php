<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\libs\Html;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\sharebetween\models\Share;
use Yii;

class ShareLink extends \yii\base\Widget
{

    /**
     * @var ContentActiveRecord
     */
    public $record;

    public function run()
    {
        if ($this->record instanceof Share) {
            return '';
        }

        if (Yii::$app->user->isGuest) {
            return '';
        }

        return Html::tag('span',
            Html::a(
                Yii::t('SharebetweenModule.base', 'Share'),
                ['/sharebetween/share', 'id' => $this->record->content->id],
                ['data-target' => '#globalModal']
            )
        );
    }
}