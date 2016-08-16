<?php

use yii\db\Migration;

class m160815_100903_initial extends Migration
{

    public function up()
    {
        $this->createTable('sharebetween_share', array(
            'id' => 'pk',
            'content_id' => 'int(11) NOT NULL',
                ), '');
        
        $this->addForeignKey('fk_content', 'sharebetween_share', 'content_id', 'content', 'id');
    }

    public function down()
    {
        echo "m160815_100903_initial cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
