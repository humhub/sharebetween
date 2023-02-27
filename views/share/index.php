<?php
/* @var $this \humhub\modules\ui\view\components\View */

/* @var $model \humhub\modules\sharebetween\models\ShareForm */

use humhub\modules\space\widgets\SpacePickerField;
use humhub\widgets\Button;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;
use humhub\modules\ui\form\widgets\ActiveForm;

?>

<?php ModalDialog::begin(['header' => Yii::t('SpaceModule.base', '<strong>Share</strong> content')]); ?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="modal-body">
        <?= $form->field($model, 'spaces')->widget(SpacePickerField::class)->label(false) ?>
        <?= $form->field($model, 'onMyProfile')->checkbox() ?>
    </div>
    <div class="modal-footer">
        <?= ModalButton::submitModal() ?>
        <?= ModalButton::cancel() ?>
    </div>
<?php ActiveForm::end() ?>
<?php ModalDialog::end(); ?>