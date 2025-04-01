<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\activities;

use humhub\modules\content\activities\ContentCreated;
use Yii;

class SharedContentCreated extends ContentCreated
{
    /**
     * @inheritdoc
     */
    public $viewName = 'shared';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('SharebetweenModule.base', 'Share Content');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('SharebetweenModule.base', 'Whenever content (e.g. a post) is shared by a user.');
    }
}
