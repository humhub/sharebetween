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
?>
<?php ModalDialog::begin(['header' => Yii::t('SpaceModule.base', '<strong>Share</strong> content')]); ?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="modal-body">
        <?= $form->field($model, 'spaces')->widget(SpacePickerField::class, [
            'url' => Url::to(['/sharebetween/share/search-spaces', 'id' => $content->id])
        ])->label(false) ?>
        <?= $form->field($model, 'onProfile')->checkbox() ?>
    </div>
    <div class="modal-footer">
        <?= ModalButton::submitModal() ?>
        <?= ModalButton::cancel() ?>
    </div>
<?php ActiveForm::end() ?>
<?php ModalDialog::end(); ?>