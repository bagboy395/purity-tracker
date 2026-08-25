<?php

use yii\db\Migration;

class m260825_125002_create_achievements_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%achievements}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),

            'achievement' => $this->string(100)->notNull(),

            'days' => $this->integer()->notNull(),

            'unlocked_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-achievements-user_id',
            '{{%achievements}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-achievements-user_id',
            '{{%achievements}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Prevent the same achievement from being unlocked twice
        $this->createIndex(
            'unique-user-achievement',
            '{{%achievements}}',
            ['user_id', 'achievement'],
            true
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-achievements-user_id',
            '{{%achievements}}'
        );

        $this->dropIndex(
            'unique-user-achievement',
            '{{%achievements}}'
        );

        $this->dropIndex(
            'idx-achievements-user_id',
            '{{%achievements}}'
        );

        $this->dropTable('{{%achievements}}');
    }
}