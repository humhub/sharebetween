<?php

use yii\helpers\Html;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\content\widgets\WallEntry;
use humhub\modules\content\widgets\WallEntryControls;

//$user = $object->content->user;
$container = $object->content->container;
$sharedContent = $object->sharedContent->getPolymorphicRelation();
?>

<div class="panel panel-default wall_<?php echo $object->getUniqueId(); ?>">
    <div class="panel-body">
        <div class="media">
            <ul class="nav nav-pills preferences">
                <li class="dropdown ">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <?php echo \humhub\modules\content\widgets\WallEntryControls::widget(['object' => $object, 'wallEntryWidget' => $wallEntryWidget]); ?>
                    </ul>
                </li>
            </ul>

            <p>
                <?= Yii::t('SharebetweenModule.base', '{displayName} shared a {contentType}.', ['displayName' => Html::a($user->displayName, $user->getUrl(), ['style' => 'color: #e5c150']), 'contentType' => Html::a($sharedContent->getContentName(), $sharedContent->content->getUrl())]); ?>
            </p>

            <div class="content" id="wall_content_<?php echo $object->getUniqueId(); ?>">
                <?php echo $content; ?>
            </div>

        </div>
    </div>

</div>
