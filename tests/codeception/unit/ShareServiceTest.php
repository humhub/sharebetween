<?php

namespace humhub\modules\sharebetween\codeceptionTest\unit;

use humhub\modules\post\models\Post;
use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\space\models\Space;
use tests\codeception\_support\HumHubDbTestCase;
use Yii;

class ShareServiceTest extends HumHubDbTestCase
{

    public function testCreateRemoveShare()
    {
        $this->becomeUser('user2');
        $postUser2Space2Public = Post::findOne(['id' => 10]);
        $space3 = Space::findOne(['id' => 3]);

        $shareService = (new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()));

        $this->assertTrue($shareService->create($space3));
        $this->becomeUser('user2');// TODO: need to investigate why current user is logged out after insert a Share
        $this->assertTrue($shareService->exist($space3));
        $shareService->delete($space3);
        $this->assertFalse($shareService->exist($space3));
    }
    public function testDeletedContent()
    {
        $this->becomeUser('user2');
        $postUser2Space2Public = Post::findOne(['id' => 10]);
        $space3 = Space::findOne(['id' => 3]);

        $shareService = (new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()));
        $this->assertTrue($shareService->create($space3));

        $postUser2Space2Public->hardDelete();
        $this->assertCount(0, $shareService->list());
    }

    public function testSoftDeletedContent()
    {
        $this->becomeUser('user2');

        $postUser2Space2Public = Post::findOne(['id' => 10]);
        $space3 = Space::findOne(['id' => 3]);

        $shareService = (new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()));
        $this->assertTrue($shareService->create($space3));

        $postUser2Space2Public->delete(); // Soft Delete
        $this->assertCount(0, $shareService->list());
    }

    public function testListShares()
    {
        $this->becomeUser('user2');
        $postUser2Space2Public = Post::findOne(['id' => 10]);
        $space1 = Space::findOne(['id' => 1]);
        $space3 = Space::findOne(['id' => 3]);

        $shareService = (new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()));

        $this->assertTrue($shareService->create($space1));
        $this->assertTrue($shareService->create($space3));
        $shares = $shareService->list();
        $this->assertCount(2, $shares);
        $this->assertTrue(($shares[0]->guid === $space1->guid));
        $this->assertTrue(($shares[1]->guid === $space3->guid));
    }

    public function testCanShare()
    {
        $this->becomeUser('user2');

        $space3 = Space::findOne(['id' => 3]);
        $space5 = Space::findOne(['id' => 5]);

        /**
         * Public Post Share
         */
        $postUser2Space2Public = Post::findOne(['id' => 10]);
        $this->assertNotNull($postUser2Space2Public);

        // User 2 is Moderator in Space 3
        $this->assertTrue((new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()))->canCreate($space3));
        // User 2 is not in Space 5
        $this->assertFalse((new ShareService($postUser2Space2Public, Yii::$app->user->getIdentity()))->canCreate($space5));

        /**
         * Private Post Share
         */
        $postUser2Space2Private = Post::findOne(['id' => 11]);
        $this->assertNotNull($postUser2Space2Private);

        // Private Posts can never shared
        $this->assertFalse((new ShareService($postUser2Space2Private, Yii::$app->user->getIdentity()))->canCreate($space3));
        $this->assertFalse((new ShareService($postUser2Space2Private, Yii::$app->user->getIdentity()))->canCreate($space5));
    }

}
