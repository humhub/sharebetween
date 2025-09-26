<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\helpers\Html;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\sharebetween\services\ShareService;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

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

        if ((int)$this->record->content->visibility !== Content::VISIBILITY_PUBLIC) {
            return '';
        }

        if (!$this->record->content->getStateService()->isPublished()) {
            return '';
        }

        if (Yii::$app->user->isGuest) {
            return '';
        }

        return Html::tag(
            'span',
            Html::a(
                Yii::t('SharebetweenModule.base', 'Share') . $this->getCounter(),
                '#',
                [
                    'data-action-click' => 'ui.modal.load',
                    'data-action-click-url' => Url::toRoute(['/sharebetween/share', 'id' => $this->record->content->id]),
                ],
            ),
            ['class' => 'share-between-container'],
        );
    }

    private function getCounter()
    {
        $count = count((new ShareService($this->record, Yii::$app->user->getIdentity()))->list());
        if ($count === 0) {
            return '';
        }

        return sprintf(' (%d)', $count);
    }
}
