
<?php

use yii\db\Migration;

/**
 * Creates the notifications table.
 */
class m261010_170740_create_notifications_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(150)->notNull(),
            'message' => $this->text()->notNull(),
            'type' => $this->string(50)->notNull()->defaultValue('general'),
            'is_read' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-notifications-user_id',
            '{{%notifications}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-notifications-user_id',
            '{{%notifications}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-notifications-user_id',
            '{{%notifications}}'
        );

        $this->dropTable('{{%notifications}}');
    }
}
