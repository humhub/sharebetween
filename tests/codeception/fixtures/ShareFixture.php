<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2023 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\news\tests\codeception\fixtures;

use humhub\modules\sharebetween\models\Share;
use yii\test\ActiveFixture;

class ShareFixture extends ActiveFixture
{
    public $modelClass = Share::class;
    public $dataFile = '@sharebetween/tests/codeception/fixtures/data/share.php';
}
