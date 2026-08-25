<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goals}}`.
 */
class m260721_100510_create_goals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goals}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'target_days' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'is_completed' => $this->boolean()->defaultValue(false),
            'updated_at' => $this->timestamp()->null(),
        ]);

        //Add foreign key: goals.user_id -> user.id
        $this->addForeignKey(
            'fk-goals-user_id',
            '{{%goals}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
    'fk-goals-user_id',
    '{{%goals}}'
);

$this->dropTable('{{%goals}}');
    }
}
