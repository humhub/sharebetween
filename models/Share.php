<?php

namespace humhub\modules\sharebetween\models;

use humhub\modules\sharebetween\widgets\WallEntry;
use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\components\ContentContainerActiveRecord;

class Share extends ContentActiveRecord
{
    /**
     * @inheritdoc
     */
    public $wallEntryClass = WallEntry::class;
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
        return $this->hasOne(Content::class, ['id' => 'content_id']);
    }

    public function getContentRecord(): ContentActiveRecord
    {
        return $this->sharedContent->getModel();
    }

    public static function create(Content $content, ContentContainerActiveRecord $container)
    {
        if (self::hasShare($content, $container)) {
            throw new \yii\web\HttpException(400, 'Shared!');
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

    public function getIcon()
    {
        return 'fa-share-alt';
    }

}
