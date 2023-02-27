<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\libs\Html;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\sharebetween\services\ShareService;
use Yii;
use yii\base\Widget;

class ShareLink extends Widget
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
                Yii::t('SharebetweenModule.base', 'Share') . $this->getCounter(),
                ['/sharebetween/share', 'id' => $this->record->content->id],
                ['data-target' => '#globalModal']
            )
        );
    }

    private function getCounter()
    {
        $count = count((new ShareService($this->record, Yii::$app->user->getIdentity()))->list());
        if ($count === 0) {
            return '';
        }

        return ' (' . $count . ')';
    }
}