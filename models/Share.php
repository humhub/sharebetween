<?php

namespace humhub\modules\sharebetween\models;

use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\sharebetween\widgets\WallEntry;
use Yii;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * Class for shared content record between spaces or users
 *
 * @property int $content_id
 * @property-read Content $sharedContent
 */
class Share extends ContentActiveRecord
{
    /**
     * @inheritdoc
     */
    public $wallEntryClass = WallEntry::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sharebetween_share';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id'], 'required'],
        ];
    }

    public function getSharedContent(): ActiveQuery
    {
        return $this->hasOne(Content::class, ['id' => 'content_id']);
    }

    public function getContentRecord(): ContentActiveRecord
    {
        return $this->sharedContent->getModel();
    }

    public function getShareService(?IdentityInterface $user): ShareService
    {
        if ($user === null) {
            /** @var IdentityInterface $user */
            $user = Yii::$app->user->getIdentity();
        }

        return new ShareService($this->getContentRecord(), $user);
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return 'fa-share-alt';
    }

    /**
     * @inheritdoc
     */
    public function getContentName()
    {
        return Yii::t('SharebetweenModule.base', 'Shared content');
    }

    /**
     * @inheritdoc
     */
    public function getContentDescription()
    {
        return $this->sharedContent->getContentDescription();
    }
}
