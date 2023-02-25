<?php

namespace humhub\modules\sharebetween\models;

use Yii;
use yii\base\Model;

/**
 * @author Luke
 * @package humhub.modules_core.space.forms
 * @since 0.5
 */
class ShareForm extends Model
{
    public $space;

    public function rules()
    {
        return array(
            array('space', 'safe'),
            //array('inviteExternal', 'checkInviteExternal'),
        );
    }

}
