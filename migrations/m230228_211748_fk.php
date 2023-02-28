<?php

use yii\db\Migration;

/**
 * Class m230228_211748_fk
 */
class m230228_211748_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('sharebetween_share', 'content_id', $this->integer()->null());
        $this->dropForeignKey('fk_content', 'sharebetween_share');
        $this->addForeignKey('fk_content', 'sharebetween_share', 'content_id', 'content', 'id', 'SET NULL', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230228_211748_fk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230228_211748_fk cannot be reverted.\n";

        return false;
    }
    */
}
