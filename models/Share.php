<?php

namespace humhub\modules\sharebetween\models;

use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\sharebetween\widgets\WallEntry;
use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use yii\web\IdentityInterface;

/**
 *
 * @property $content_id int
 */
class Share extends ContentActiveRecord
{
    /**
     * @inheritdoc
     */
    public $wallEntryClass = WallEntry::class;

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


    public function getShareService(?IdentityInterface $user)
    {
        if ($user === null) {
            /** @var IdentityInterface $user */
            $user = Yii::$app->user->getIdentity();
        }

        return new ShareService($this->getContentRecord(), $user);
    }

    public function getIcon()
    {
        return 'fa-share-alt';
    }

}
