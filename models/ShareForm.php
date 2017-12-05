<?php
namespace humhub\modules\sharebetween\models;

use humhub\modules\space\models\Space;
use humhub\modules\content\models\Content; //   Add 


use Yii;
use yii\base\Model;
/**
 * Description of ShareForm
 *
 * @author buddha modif Patman
 */
class ShareForm extends Model
{
        /**
         * SpaceId selection array of the form.
         * @var type
         */
        public $spaceSelection;
        
        /**
         * Field for Invite GUIDs
         *
         * @var type
         */

        


    /**
     * Returns an id => spacename array representation of the given $spaces array.
     * @param array $spaces array of Space models
     * @return type array in form of id => spacename
     */
        
        public static function getSpaceItems(Content $content,$spaces = null)
    {
        if($spaces == null) {
            $spaces =  \humhub\modules\space\models\Membership::GetUserSpaces();
        }
        
        $result = [];
        foreach ($spaces as $space) {
            if($content->container->guid != $space->guid)
                $result[$space->guid] = $space->name;
        }
        return $result;
    }
    
  
    
    

}