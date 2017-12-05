<?php

namespace humhub\modules\sharebetween\controllers;

use Yii;
use humhub\modules\content\models\Content;
use humhub\modules\sharebetween\models\ShareForm;
use humhub\modules\sharebetween\models\Share;

use humhub\modules\space\models;


use humhub\compat\HForm;




class ShareController extends \humhub\components\Controller
{
    
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className()
            ]
        ];
    }
    
    public function actionIndex()
    {
        $error =  false;
        $space = new ShareForm();
        $content = Content::findOne(['id' => Yii::$app->request->get('id')]);
         
      /*  if (!$content->canView()) {
            throw new \yii\web\HttpException('400', 'Permission denied!');
        }*/
        
        if (Yii::$app->request->isPost) {
            $ShareForm = Yii::$app->request->post('ShareForm');
            if ($ShareForm) {
                if ($ShareForm['spaceSelection']) {
                foreach ($ShareForm['spaceSelection'] as $guid) {
                            $shareSpace = \humhub\modules\space\models\Space::findOne(['guid' => trim($guid)]);
                            if ($shareSpace) {
                                Share::create($content,$shareSpace); 
                            }
                        }
                    return $this->renderAjax('success');
                    }  
                    else{
                      $error =  true;
                    }
             }
        
        }
        


        // Build Form Definition
        $definition = [];
        
        $definition['elements']['ShareForm'] = [
            'type' => 'form',
           // 'title' => 'Share',
            
            'elements' => [
                
                'spaceSelection' => [
                    'id' => 'spaceselection',
                    'type' => 'multiselectdropdown',
                    'items' => ShareForm::getSpaceItems($content), ///Add

                ]

            ],
        ];

        // Buttons
        $definition['buttons'] = array(
            'save' => array(
                'type' => 'submit',
                'label' => Yii::t('AdminModule.controllers_UserController', 'Partager'),
                'class' => 'btn btn-primary hidden',
            ),
        );
        

        
        $form = new HForm($definition);
        $form->models['ShareForm'] = $space;
           
         

        return $this->renderAjax('index',
            ['hForm' => $form,
                'space' => $space,
                'content' => $content,
                'error'=> $error
            ]);
    }
    
}










