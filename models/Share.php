<?php

namespace humhub\modules\sharebetween\models;

use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\components\ContentContainerActiveRecord;

class Share extends ContentActiveRecord
{

    public $wallEntryClass = 'humhub\modules\sharebetween\widgets\StreamEntry';
    public $autoAddToWall = true;

    public static function tableName()
    {
        return 'sharebetween_share';
    }

    public function rules()
    {
        return array(
            [['content_id'], 'required'],
        );
    }

    public function getSharedContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    public static function create(Content $content, ContentContainerActiveRecord $container)
    {
 
        if (self::hasShare($content, $container)) {
            return;
        }
        
        $share = new self;
        $share->content_id = $content->id;
        $share->content->container = $container;
        $share->save();
    }

    public static function hasShare(Content $content, ContentContainerActiveRecord $container)
    {
        $share = Share::find()->joinWith('content')->where(['sharebetween_share.content_id' => $content->id, 'content.contentcontainer_id' => $container->id])->one();
        if ($share !== null) {
            return true;
        }

        return false;
    }

    public static function deleteShare(Content $content, ContentContainerActiveRecord $container)
    {
        $shares = Share::find()->joinWith('content')->where(['sharebetween_share.content_id' => $content->id, 'content.contentcontainer_id' => $container->id])->all();
        foreach ($shares as $share) {
            $share->delete();
        }
    }
    
  
    /**
     * Checks if the user can share this content.
     * This is only allowed for workspace owner.
     *
     * @return boolean
     */
    public function canShare(Content $content)
    {
        
        if ($content->isArchived()) {
            return false;
        }
        
        // anybody can share 
        //return $content->getContainer()->permissionManager->can(new \humhub\modules\content\permissions\ManageContent());
        return true;
    }
    
    
    
    
    


}