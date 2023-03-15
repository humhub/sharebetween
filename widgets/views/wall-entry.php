<?php

use humhub\modules\content\widgets\stream\StreamEntryWidget;
use humhub\modules\sharebetween\models\Share;

/* @var $share Share */
?>
<?php if ($share->getContentRecord()->content->canView()) : ?>
    <?= StreamEntryWidget::renderStreamEntry($share->getContentRecord()) ?>
<?php else : ?>
    <?= Yii::t('SharebetweenModule.base', 'You don\'t have access to this content.') ?>
<?php endif; ?>