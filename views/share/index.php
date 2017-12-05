<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


use yii\helpers\Url;
use humhub\modules\space\models\Space;


\humhub\modules\sharebetween\assets\Select2ExtensionAssetModal::register($this);

?>
 <div id="shareModal"class="modal-dialog modal-dialog-small animated fadeIn"> 
    <div class="modal-content">  
       <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?php echo Yii::t('SharebetweenModule.base', '<strong>Share content</strong><BR><BR><span>Please select spaces</span>'); ?>
                </h4>
        </div>
        <div class="modal-body">
        <div class="text-center">
                        <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['data-ui-tabbed-form' => '']]); ?>
                        <?php echo $hForm->render($form); ?>
                        
                        
                         <div class="modal-footer">

                        <?php
                        echo \humhub\widgets\AjaxButton::widget([
                            'label' => Yii::t('SharebetweenModule.base', 'Share'),
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),                               
                                'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html);setError();} '),
                                'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id] ), 
                            ],
                            'htmlOptions' => [
                                'class' => 'btn btn-primary'

                            ]
                        ]);
                        ?>
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal"><?php echo Yii::t('SharebetweenModule.base', 'Close'); ?></button>
                    </div>                    
                 
                <?php \yii\widgets\ActiveForm::end(); ?>


                </div>
                <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'invite-loader', 'cssClass' => 'loader-modal hidden']); ?>

            </div>
</div>

        </div> 



   </div>

 </div> 
 

 
 <style>
 .warning 
 {
 color:red;
 }
 </style>
<?php

if ($error) {
    echo '<script type="text/javascript">';
    echo 'var setError = function() {$(".modal-dialog").removeClass("fadeIn");$("#shareModal").addClass("shake");$("#shareModal h4#myModalLabel.modal-title").children().eq(3).addClass("warning") };';
    echo '</script>';
}
else
{
    echo '<script type="text/javascript">';
    echo 'var setError = function() {$(".warning").removeClass("warning")};';
    echo '</script>';
}


?>

<script type="text/javascript">

var checkForMultiSelectDropDown = function() {
    //We have to overwrite the the result gui after every change
    $('.multiselect_dropdown').select2({
        width: '100%',
        closeOnSelect: false,
         }).on('change', function () {
        $(this).trigger('update');
    }).on('select2:open', function () {
        $(this).data('isOpen', true);
    }).on('select2:close', function () {
        $(this).data('isOpen', false);
    }).on('update', function () {
        var $container = $(this).next('.select2-container');
        var $choices = $container.find('.select2-selection__choice');
        $choices.addClass('userInput');
        var $closeButton = $('<i class="fa fa-times-circle"></i>');
        $closeButton.on('click', function () {
            $(this).siblings('span[role="presentation"]').trigger('click');
        });
        $choices.append($closeButton);
    });

//For highlighting the input
    $(".select2-container").on("focusin", function () {
        $(this).find('.select2-selection').addClass('select2-selection--focus');
        $(".warning").removeClass("warning");
    });

//Since the focusout of the ontainer is called when the dropdown is opened we have to use this focusout
    $(document).off('focusout', '.select2-search__field').on('focusout', '.select2-search__field', function () {
        if (!$(this).closest('.select2-container').prev('.multiselect_dropdown').data('isOpen')) {
            $(this).closest('.select2-selection').removeClass('select2-selection--focus');
        }
    });

    $('.multiselect_dropdown').trigger('update');
}






$(document).ready(function () {
	$("label[for='spaceselection']").remove();
    $.fn.select2.defaults = {};
    checkForMultiSelectDropDown(); 
});

</script>