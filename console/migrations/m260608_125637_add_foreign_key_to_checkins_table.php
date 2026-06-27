<?php

use yii\db\Migration;

class m260608_125637_add_foreign_key_to_checkins_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addForeignKey(
                'fk-checkins-user_id',
                'checkins',
                'user_id',
                'user',
                'id',
                'CASCADE'
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey(
        'fk-checkins-user_id',
        'checkins'
      );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260608_125637_add_foreign_key_to_checkins_table cannot be reverted.\n";

        return false;
    }
    */
}
