<?php

namespace humhub\modules\sharebetween\models;

use Yii;
use yii\base\Model;

class ShareForm extends Model
{
    public $spaces = [];
    public $onProfile = false;

    public function rules()
    {
        return [
            ['spaces', 'safe'],
            ['onProfile', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'spaces' => Yii::t('SharebetweenModule.base', 'Spaces'),
            'onProfile' => Yii::t('SharebetweenModule.base', 'Share this content on your profile stream'),
        ];
    }

    public function attributeHints()
    {
        return [
            'spaces' => Yii::t('SharebetweenModule.base', 'Select Spaces here on which the content is to be additionally displayed.'),
            'onProfile' => Yii::t('SharebetweenModule.base', 'Content you create is automatically displayed on your profile.'),
        ];
    }

    public function load($data, $formName = null)
    {
        $load = parent::load($data, $formName);
        // Accept only a list of GUID strings
        $this->spaces = is_array($this->spaces)
            ? array_values(array_filter($this->spaces, 'is_string'))
            : [];

        if (!is_scalar($this->onProfile)) {
            $this->onProfile = false;
        }
        return $load;
    }

}
