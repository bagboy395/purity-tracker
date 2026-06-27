<?php

use yii\db\Migration;

class m260604_120358_fix_user_table_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'status', $this->smallInteger()->notNull()->defaultValue(10));
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'status');
        $this->dropColumn('{{%user}}', 'verification_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260604_120358_fix_user_table_structure cannot be reverted.\n";

        return false;
    }
    */
}
