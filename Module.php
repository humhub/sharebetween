<?php

namespace humhub\modules\sharebetween;

use humhub\modules\content\components\ContentContainerModule;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;

class Module extends ContentContainerModule
{
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (models\Share::find()->all() as $share) {
            $share->hardDelete();
        }

        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            Space::class,
            User::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getContentClasses(): array
    {
        return [Share::class];
    }

}
