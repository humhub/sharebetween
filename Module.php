<?php

namespace humhub\modules\sharebetween;

class Module extends \humhub\components\Module
{

    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (models\Share::find()->all() as $share) {
            $share->delete();
        }

        parent::disable();
    }

}
