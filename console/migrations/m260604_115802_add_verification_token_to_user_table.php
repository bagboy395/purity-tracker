<?php

use yii\db\Migration;

class m260604_115802_add_verification_token_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropcolumn('{{%user}}', 'verification_token');

        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260604_115802_add_verification_token_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
