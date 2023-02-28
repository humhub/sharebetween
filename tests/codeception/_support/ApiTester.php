<?php
namespace sharebetween;

use humhub\modules\sharebetween\helpers\RestDefinitions;
use humhub\modules\sharebetween\models\Sharebetween;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \ApiTester
{
    use _generated\ApiTesterActions;
}
