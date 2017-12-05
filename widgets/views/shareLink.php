<?php
/* @var $this humhub\components\View */

use yii\helpers\Url;
?>
<li>
    <a href="<?=Url::to(['/sharebetween/share', 'id' => $id]); ?>" data-target="#globalModal"><i class="fa fa-share-alt"></i> <?php echo Yii::t('SharebetweenModule.base', 'Share'); ?></a>
</li>