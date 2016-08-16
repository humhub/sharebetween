<?php

namespace humhub\modules\sharebetween\controllers;

use Yii;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\sharebetween\models\Share;

class ShareController extends \humhub\components\Controller
{

    public function actionIndex()
    {
        $model = new ShareForm();
        $content = Content::findOne(['id' => Yii::$app->request->get('id')]);

        if (!$content->canView()) {
            throw new \yii\web\HttpException('400', 'Permission denied!');
        }

        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->get('self') == 1) {
                Share::create($content, Yii::$app->user->getIdentity());
                return $this->renderAjax('success');
            } else {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    foreach ($model->getSpaces() as $space) {
                        Share::create($content, $space);
                    }
                    return $this->renderAjax('success');
                }
            }
        }


        return $this->renderAjax('index', ['content' => $content, 'model' => $model]);
    }

}
