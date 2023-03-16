<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2023 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\assets;

use humhub\components\assets\AssetBundle;

class Assets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $defer = true;

    /**
     * @inheritdoc
     */
    public $sourcePath = '@sharebetween/resources';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/sharebetween.min.css'
    ];

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => false
    ];
}
