
<?php

use yii\db\Migration;

class m261010_154932_create_notification_preferences_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%notification_preferences}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),

            // Master switch for in-app notifications
            'notifications_enabled' => $this->boolean()->notNull()->defaultValue(true),

            // Notification categories
            'achievement_notifications' => $this->boolean()->notNull()->defaultValue(true),
            'goal_notifications' => $this->boolean()->notNull()->defaultValue(true),
            'streak_notifications' => $this->boolean()->notNull()->defaultValue(true),
            'motivation_notifications' => $this->boolean()->notNull()->defaultValue(true),
            'scripture_notifications' => $this->boolean()->notNull()->defaultValue(true),
            'checkin_reminders' => $this->boolean()->notNull()->defaultValue(true),

            // Timestamps
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-notification_preferences-user_id',
            '{{%notification_preferences}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-notification_preferences-user_id',
            '{{%notification_preferences}}',
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
            'fk-notification_preferences-user_id',
            '{{%notification_preferences}}'
        );

        $this->dropTable('{{%notification_preferences}}');
    }
}
