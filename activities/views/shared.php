<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\sharebetween\models\Share;
use humhub\modules\user\models\User;
use yii\helpers\Html;

/* @var User $originator */
/* @var Share $source */

echo Yii::t('SharebetweenModule.base', '{user} shared something interesting from Space {space}.', [
    '{user}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
    '{space}' => '<strong>' . Html::encode($source->content->container->displayName) . '</strong>',
]);
