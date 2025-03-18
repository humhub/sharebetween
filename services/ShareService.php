<?php

namespace humhub\modules\sharebetween\services;

use humhub\libs\BasePermission;
use humhub\modules\content\components\ActiveQueryContent;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\content\models\ContentContainerDefaultPermission;
use humhub\modules\post\permissions\CreatePost;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use yii\web\IdentityInterface;

final class ShareService
{
    private ContentActiveRecord $record;

    private IdentityInterface $user;

    public function __construct(ContentActiveRecord $contentRecord, IdentityInterface $user)
    {
        $this->user = $user;
        $this->record = $contentRecord;
    }

    /**
     * @return ContentContainerActiveRecord[]
     */
    public function list(): array
    {
        $container = [];
        foreach ($this->getShareQuery()->all() as $share) {
            /** @var Share $share */
            $container[] = $share->content->container;
        }
        return $container;
    }

    public function shareOnContainerGuids(array $newGuids)
    {
        $alreadySharedGuids = array_map(function (ContentContainerActiveRecord $record) {
            return $record->guid;
        }, $this->list());

        // Deleted GUIDs
        foreach (array_diff($alreadySharedGuids, $newGuids) as $guid) {
            if ($container = ContentContainer::findRecord($guid)) {
                if ($this->canCreate($container)) {
                    $this->delete($container);
                }
            }
        }

        // Added GUIDs
        foreach (array_diff($newGuids, $alreadySharedGuids) as $guid) {
            if ($container = ContentContainer::findRecord($guid)) {
                if ($this->canCreate($container)) {
                    $this->create($container);
                }
            }
        }
    }

    public function canCreate(ContentContainerActiveRecord $container): bool
    {
        if ($this->record->content->visibility !== Content::VISIBILITY_PUBLIC) {
            return false;
        }

        if (!$this->record->content->getStateService()->isPublished()) {
            return false;
        }

        if ($this->record->content->contentcontainer_id === $container->contentcontainer_id) {
            return false;
        }

        if ($container instanceof User && Yii::$app->getModule('user')->profileDisableStream) {
            return false;
        }

        if ($this->user->isSystemAdmin()) {
            return true;
        }

        if (!$container->getPermissionManager($this->user)->can(CreatePost::class)) {
            return false;
        }

        return true;
    }

    public function create(ContentContainerActiveRecord $container): bool
    {
        $share = new Share($container);
        $share->content_id = $this->record->content->id;
        return $share->save();
    }

    public function delete(ContentContainerActiveRecord $container): void
    {
        foreach ($this->getShareByContainer($container)->all() as $share) {
            $share->hardDelete();
        }
    }

    public function exist(ContentContainerActiveRecord $container): bool
    {
        return ($this->getShareByContainer($container)->count() > 0);
    }

    private function getShareQuery(): ActiveQueryContent
    {
        return Share::find()->joinWith('content')->readable()
            ->andWhere([
                'content.created_by' => $this->user->id,
                'sharebetween_share.content_id' => $this->record->content->id,
            ]);
    }

    private function getShareByContainer(ContentContainerActiveRecord $container): ActiveQueryContent
    {
        return $this->getShareQuery()->andWhere(['content.contentcontainer_id' => $container->contentcontainer_id]);
    }

    public function getDefaultAllowedGroups(): array
    {
        $defaultAllowedGroups = (new CreatePost())->defaultAllowedGroups;

        /* @var ContentContainerDefaultPermission[] $defaultPermissions */
        $defaultPermissions = ContentContainerDefaultPermission::find()
            ->where(['contentcontainer_class' => Space::class])
            ->andWhere(['permission_id' => CreatePost::class])
            ->all();

        foreach ($defaultPermissions as $defaultPermission) {
            switch ($defaultPermission->state) {
                case BasePermission::STATE_ALLOW:
                    if (!in_array($defaultPermission->group_id, $defaultAllowedGroups)) {
                        $defaultAllowedGroups[] = $defaultPermission->group_id;
                    }
                    break;
                case BasePermission::STATE_DENY:
                    if (($i = array_search($defaultPermission->group_id, $defaultAllowedGroups)) !== false) {
                        unset($defaultAllowedGroups[$i]);
                    }
                    break;
            }
        }

        return $defaultAllowedGroups;
    }
}
