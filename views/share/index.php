<?php

use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;
use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $model ShareForm */
/* @var $content Content */
/* @var $allowShareOnProfile bool */
?>
<?php ModalDialog::begin(['header' => Yii::t('SharebetweenModule.base', '<strong>Share</strong> content')]); ?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="modal-body">
        <?= $form->field($model, 'spaces')->widget(SpacePickerField::class, [
            'url' => Url::to(['/sharebetween/share/search-spaces', 'id' => $content->id])
        ])->label(false) ?>
        <?php if ($allowShareOnProfile) : ?>
            <?= $form->field($model, 'onProfile')->checkbox() ?>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <?= ModalButton::submitModal() ?>
        <?= ModalButton::cancel() ?>
    </div>
<?php ActiveForm::end() ?>
<?php ModalDialog::end(); ?>