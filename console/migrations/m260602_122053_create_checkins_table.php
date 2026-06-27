<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checkins}}`.
 */
class m260602_122053_create_checkins_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checkins}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'checkin_date' => $this->date()->notNull(),
            'created_at' => $this->integer()->notNull(),
           
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%checkins}}');
    }
}
