<?php


/** @var $share \humhub\modules\sharebetween\models\Share * */

use humhub\modules\content\widgets\stream\StreamEntryWidget;

?>
<?= StreamEntryWidget::renderStreamEntry($share->getContentRecord()); ?>
