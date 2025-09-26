<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use yii\helpers\Html;

/* @var User $originator */
/* @var Share $source */

$container = $source->sharedContent->container;

if ($container instanceof Space) {
    echo Yii::t('SharebetweenModule.base', '{user} shared something interesting from Space {space}.', [
        'user' => Html::tag('strong', Html::encode($originator->displayName)),
        'space' => Html::tag('strong', Html::encode($container->displayName)),
    ]);
} elseif ($container instanceof User) {
    echo Yii::t('SharebetweenModule.base', '{user} shared something interesting from user {sourceUser}.', [
        'user' => Html::tag('strong', Html::encode($originator->displayName)),
        'sourceUser' => Html::tag('strong', Html::encode($container->displayName)),
    ]);
} else {
    echo Yii::t('SharebetweenModule.base', '{user} shared something interesting from dashboard.', [
        'user' => Html::tag('strong', Html::encode($originator->displayName)),
    ]);
}
