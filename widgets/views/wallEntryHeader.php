<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2023 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\helpers\Html;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\widgets\stream\WallStreamEntryOptions;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\widgets\bootstrap\Link;
use humhub\widgets\TimeAgo;

/* @var $model Share */
/* @var $permaLink string */
/* @var $renderOptions WallStreamEntryOptions */

$sourceContainer = $model->getContentRecord()->content->container;
$currentContainer = $model->content->container;
?>
<div class="wall-entry-header-info flex-grow-1">
    <?= Icon::get('share') ?>
    <?= $sourceContainer instanceof ContentContainerActiveRecord
        ? Link::to($sourceContainer->getDisplayName(), $sourceContainer->createUrl())
        : Link::to(Yii::t('DashboardModule.base', 'Dashboard'), ['/dashboard/dashboard']) ?>
    <?= Icon::get('caret-right', ['htmlOptions' => ['style' => 'margin-left:3px;font-size:80%']]) ?>
    <?= Yii::t('SharebetweenModule.base', '{spaceName} by {userName}', [
        'spaceName' => Link::to($currentContainer->getDisplayName(), $currentContainer->createUrl()),
        'userName' => '<strong>' . Html::containerLink($model->content->createdBy, ['class' => 'wall-entry-container-link']) . '</strong>',
    ]) ?>
    &middot;
    <?= Link::to(TimeAgo::widget(['timestamp' => $model->content->created_at]), $permaLink) ?>
</div>
