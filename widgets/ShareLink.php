<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\widgets;

use Yii;
use humhub\modules\content\components\ContentContainerController;

class ShareLink extends \yii\base\Widget
{

    /**
     * @var \humhub\modules\content\components\ContentActiveRecord
     */
    public $content;

    /**
     * Executes the widget.
     */
    public function run()
    {
        if ($this->content instanceof Share) {
            return;
        }
        
        return $this->render('shareLink', array(
                    'object' => $this->content,
                    'id' => $this->content->content->id,
        ));
    }

}
