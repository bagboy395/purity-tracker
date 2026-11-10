
<?php

use yii\db\Migration;

/**
 * Adds an API token column to the existing user table.
 */
class m261102_101839_add_api_token_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%user}}',
            'api_token',
            $this->string(64)->null()->unique()
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'api_token');
    }
}
