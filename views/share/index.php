<?php

use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\widgets\modal\ModalButton;
use humhub\widgets\modal\Modal;
use yii\helpers\Url;

/* @var $model ShareForm */
/* @var $content Content */
/* @var $allowShareOnProfile bool */
?>
<?php $form = Modal::beginFormDialog([
        'title' => Yii::t('SharebetweenModule.base', '<strong>Share</strong> content'),
        'footer' => ModalButton::cancel() . ' ' . ModalButton::save()->submit(),
    ]); ?>
    <?= $form->field($model, 'spaces')->widget(SpacePickerField::class, [
        'url' => Url::to(['/sharebetween/share/search-spaces', 'id' => $content->id]),
        'minInput' => 0,
    ])->label(false) ?>
    <?php if ($allowShareOnProfile) : ?>
        <?= $form->field($model, 'onProfile')->checkbox() ?>
    <?php endif; ?>
<?php Modal::endFormDialog(); ?>
