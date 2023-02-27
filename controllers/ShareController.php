<?php

namespace humhub\modules\sharebetween\controllers;

use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\space\models\Space;
use humhub\widgets\ModalClose;
use Yii;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;

class ShareController extends \humhub\components\Controller
{
    public function actionIndex()
    {
        $content = Content::findOne(['id' => (int)Yii::$app->request->get('id')]);
        if (!$content || !$content->canView()) {
            return $this->forbidden();
        }

        $shareService = new ShareService($content->getModel(), Yii::$app->user->getIdentity());
        $model = new ShareForm();
        foreach ($shareService->list() as $containerActiveRecord) {
            if ($containerActiveRecord instanceof Space) {
                $model->spaces[] = $containerActiveRecord->guid;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $shareService->shareOnContainerGuids($model->spaces);

            $entrySelector = '$(\'[data-ui-widget="stream.StreamEntry"][data-content-key='.$content->id.']\')';
            return ModalClose::widget(['script' => 'humhub.modules.action.Component.instance('.$entrySelector.').reload()']);
        }

        return $this->renderAjax('index', ['content' => $content, 'model' => $model]);
    }

}