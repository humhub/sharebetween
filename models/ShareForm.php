<?php

namespace humhub\modules\sharebetween\models;

use humhub\modules\content\components\ContentContainerActiveRecord;
use yii\base\Model;

class ShareForm extends Model
{
    public $spaces = [];
    public $onMyProfile;

    public function rules()
    {
        return [
            ['spaces', 'safe'],
            ['onMyProfile', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'spaces' => 'Spaces',
            'onMyProfile' => 'Share this content on your profile stream'
        ];
    }

    public function attributeHints()
    {
        return [
            'spaces' => 'Select Spaces here on which the content is to be additionally displayed.',
            'onMyProfile' => 'Content you create is automatically displayed on your profile.',
        ];
    }

    public function load($data, $formName = null)
    {
        $load = parent::load($data, $formName);
        if (!is_array($this->spaces)) {
            $this->spaces = [];
        }
        return $load;
    }

}
