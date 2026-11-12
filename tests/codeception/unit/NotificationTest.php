<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\sharebetween\codeceptionTest\unit;

use humhub\modules\content\notifications\ContentCreatedNotification;
use humhub\modules\notification\components\NotificationManager;
use humhub\modules\notification\models\Notification;
use humhub\modules\post\models\Post;
use humhub\modules\sharebetween\models\Share;
use humhub\modules\sharebetween\notifications\SharedContentCreated;
use humhub\modules\sharebetween\services\ShareService;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use tests\codeception\_support\HumHubDbTestCase;
use Yii;

class NotificationTest extends HumHubDbTestCase
{
    public function testSharedContentNotificationHasItsOwnSentence()
    {
        $this->becomeUser('user2');
        $post = Post::findOne(['id' => 10]);
        $space3 = Space::findOne(['id' => 3]);

        $this->assertTrue((new ShareService($post, Yii::$app->user->getIdentity()))->create($space3));
        $share = $this->findShare($post);

        // Core notifies the members of the space about the new share (User1 is a member of space 3)
        $recipient = User::findOne(['username' => 'User1']);
        $record = Notification::findOne([
            'class' => ContentCreatedNotification::class,
            'user_id' => $recipient->id,
            'content_id' => $share->content->id,
        ]);
        $this->assertNotNull($record);

        // The record of the core class is rendered by the class of the module...
        $notification = NotificationManager::load($record);
        $this->assertInstanceOf(SharedContentCreated::class, $notification);

        // ...with the sentence and the placeholders of the module
        $web = $notification->asWeb();
        $this->assertStringContainsString('shared something interesting from Space', $web);
        $this->assertStringContainsString($post->content->container->displayName, $web);
        $this->assertStringContainsString(User::findOne(['username' => 'User2'])->displayName, $web);

        // The category is the one of the core notification, the switched class is not stored
        $this->assertSame('content', $notification::category()->id);
        $this->assertSame(
            ContentCreatedNotification::class,
            Notification::find()->select('class')->where(['id' => $record->id])->scalar(),
        );
    }

    public function testNotificationOfAnotherContentIsNotSwitched()
    {
        $this->becomeUser('user2');
        $post = Post::findOne(['id' => 10]);

        ContentCreatedNotification::send(User::findOne(['username' => 'User3']), $post, User::findOne(['username' => 'User2']));

        $record = Notification::findOne([
            'class' => ContentCreatedNotification::class,
            'user_id' => User::findOne(['username' => 'User3'])->id,
            'content_id' => $post->content->id,
        ]);
        $this->assertNotNull($record);
        $this->assertInstanceOf(ContentCreatedNotification::class, NotificationManager::load($record));
    }

    private function findShare(Post $post): Share
    {
        $this->becomeUser('user2');

        $share = Share::find()->where(['content_id' => $post->content->id])->one();
        $this->assertNotNull($share);

        return $share;
    }
}
