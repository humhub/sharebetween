<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2023 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\sharebetween\assets\Assets;
use humhub\modules\ui\view\components\View;

/* @var $this View */
/* @var $model ContentActiveRecord */
/* @var $header string */
/* @var $content string */

Assets::register($this);
?>
<div class="panel panel-default sharebetween-wall-entry wall_<?= $model->getUniqueId() ?>">
    <div class="panel-body">
        <?= $header ?>
        <?= $content ?>
    </div>
</div>