<?php

namespace humhub\modules\sharebetween\controllers;

use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\user\Module as UserModule;
use humhub\widgets\modal\ModalClose;
use Yii;

class ShareController extends \humhub\components\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->forbidden();
        }

        $content = Content::findOne(['id' => (int)Yii::$app->request->get('id')]);
        if (!$content || !$content->canView()) {
            return $this->forbidden();
        }

        /* @var User $user */
        $user = Yii::$app->user->getIdentity();

        $shareService = new ShareService($content->getModel(), $user);
        $model = new ShareForm();
        foreach ($shareService->list() as $containerActiveRecord) {
            if ($containerActiveRecord instanceof Space) {
                $model->spaces[] = $containerActiveRecord->guid;
            }
        }
        if ($shareService->exist($user)) {
            $model->onProfile = true;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->onProfile) {
                $shareService->shareOnContainerGuids(array_merge($model->spaces, [Yii::$app->user->getIdentity()->guid]));
            } else {
                $shareService->shareOnContainerGuids($model->spaces);
            }

            $entrySelector = '$(\'[data-ui-widget="stream.StreamEntry"][data-content-key=' . $content->id . ']\')';
            return ModalClose::widget(['script' => 'humhub.modules.action.Component.instance(' . $entrySelector . ').reload()']);
        }

        return $this->renderAjax('index', [
            'content' => $content,
            'model' => $model,
            'allowShareOnProfile' => $shareService->canCreate($user),
        ]);
    }

    public function actionSearchSpaces()
    {
        $content = Content::findOne(['id' => (int) Yii::$app->request->get('id')]);
        if (!$content || !$content->canView()) {
            return $this->forbidden();
        }

        $shareService = new ShareService($content->getModel(), Yii::$app->user->getIdentity());

        $spaces = $shareService->searchSpaces(Yii::$app->request->get('keyword', ''));

        return $this->asJson($spaces);
    }

}
