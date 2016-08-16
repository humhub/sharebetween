<?php

use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?php echo Yii::t('SpaceModule.views_space_invite', '<strong>Share</strong> content'); ?></h4>
        </div>
        <div class="modal-body">

            <br/>
            <div class="text-center">
                <ul id="tabs" class="nav nav-tabs tabs-center" data-tabs="tabs">
                    <li class="active tab-internal"><a href="#internal"
                                                       data-toggle="tab"><?php echo Yii::t('SpaceModule.views_space_invite', 'On space'); ?></a>
                    </li>
                    <li class="tab-external"><a href="#share_profile"
                                                data-toggle="tab"><?php echo Yii::t('SpaceModule.views_space_invite', 'On your profile'); ?></a>
                    </li>
                </ul>
            </div>
            <br/>

            <div class="tab-content">
                <div class="tab-pane active" id="internal">
                    <?php $form = ActiveForm::begin(); ?>

                    <?php echo Yii::t('SpaceModule.views_space_invite', 'To invite users to this space, please type their names below to find and pick them.'); ?>

                    <br/><br/>

                    <?php echo $form->field($model, 'space')->textInput(['id' => 'invite'])->label(false); ?>


                    <div class="modal-footer">

                        <?php
                        echo \humhub\widgets\AjaxButton::widget([
                            'label' => Yii::t('SpaceModule.views_space_invite', 'Share1'),
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                                'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id, 'self' => 0]),
                            ],
                            'htmlOptions' => [
                                'class' => 'btn btn-primary'
                            ]
                        ]);
                        ?>
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal"><?php echo Yii::t('SpaceModule.views_space_invite', 'Close'); ?></button>
                    </div>                    
                    <?php ActiveForm::end(); ?>

                </div>
                <div class="tab-pane" id="share_profile">
                    <?php $form = ActiveForm::begin(); ?>
                    <?php echo Yii::t('SharebetweenModule.base', 'Share this content directly on your profile.'); ?>
                    <br/><br/>

                    <div class="modal-footer">

                        <?php
                        echo \humhub\widgets\AjaxButton::widget([
                            'label' => Yii::t('SpaceModule.views_space_invite', 'Share'),
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                                'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id, 'self' => 1]),
                            ],
                            'htmlOptions' => [
                                'class' => 'btn btn-primary'
                            ]
                        ]);
                        ?>
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal"><?php echo Yii::t('SpaceModule.views_space_invite', 'Close'); ?></button>

                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
                <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'invite-loader', 'cssClass' => 'loader-modal hidden']); ?>

            </div>


        </div>



    </div>

</div>


<script type="text/javascript">

// Shake modal after wrong validation
<?php if ($model->hasErrors()) : ?>
        $('.modal-dialog').removeClass('fadeIn');
        $('.modal-dialog').addClass('shake');

        // check if there is an error at the second tab
    <?php if ($model->hasErrors('inviteExternal')) : ?>
            // show tab external tab
            $('#tabs a:last').tab('show');
    <?php endif; ?>

<?php endif; ?>

    $('.tab-internal a').on('shown.bs.tab', function (e) {
        $('#invite_tag_input_field').focus();
    })

    $('.tab-external a').on('shown.bs.tab', function (e) {
        $('#email_invite').focus();
    })


</script>