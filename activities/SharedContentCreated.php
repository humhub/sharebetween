<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\activities;

use humhub\modules\content\activities\ContentCreated;

class SharedContentCreated extends ContentCreated
{
    /**
     * @inheritdoc
     */
    public $viewName = 'shared';
}
