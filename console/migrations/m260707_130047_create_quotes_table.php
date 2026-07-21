<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotes}}`.
 */
class m260707_130047_create_quotes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quotes}}', [
            'id' => $this->primaryKey(),
            'quote' => $this->text()->notNull(),
            'author' => $this->string()->notNull(),
            'is_active'=> $this->boolean()->defaultValue(true),
            'created_at'=> $this->integer(),
            'updated_at'=> $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quotes}}');
    }
}
