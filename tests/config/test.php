<?php

use humhub\modules\news\tests\codeception\fixtures\ShareFixture;

return [
    'modules' => ['sharebetween'],
    'fixtures' => [
        'default',
        'share' => ShareFixture::class,
    ]
];