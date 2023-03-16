<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2023 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\libs\Html;
use humhub\modules\content\widgets\stream\WallStreamEntryOptions;
use humhub\modules\sharebetween\models\Share;
use humhub\widgets\Link;
use humhub\widgets\TimeAgo;

/* @var $model Share */
/* @var $permaLink string */
/* @var $renderOptions WallStreamEntryOptions */

$container = $model->getContentRecord()->content->container;
?>
<div class="wall-entry-header-info media-body">
    <?php if ($renderOptions->isShowAuthorInformationInSubHeadLine($model)) : ?>
        <?= Yii::t('SharebetweenModule.base', '{userName} shared a {contentName}', [
            'userName' => Html::containerLink($model->content->createdBy, ['class' => 'wall-entry-container-link']),
            'contentName' => $model->getContentRecord()->getContentName()
        ]) ?>
    <?php endif; ?>
    @
    <?= Link::to($container->getDisplayName(), $container->createUrl()) ?>
    &middot;
    <?= Link::to(TimeAgo::widget(['timestamp' => $model->content->created_at]), $permaLink) ?>
</div>