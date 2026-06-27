<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%journal}}`.
 */
class m260623_092756_create_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%journal}}', [
            'id' => $this->primaryKey(),
            
            //linkd each user to the journal entry
            'user_id' => $this->integer()->notNull(),

            //date of the temptation / journal entry
            'entry_date'=>$this->date()->notNull(),

            //e.g porn, fantasy ,social media,loneliness lust etc.
            'temptation_type'=>$this->string(100)->notNull(),

            //scale 1 to 10
            'intensity' => $this->integer()->notNull(),

            //what happened/trigger /context
            'what_happened'=>$this->text()->notNull(),

            //how the user responded
            'how_responded'=>$this->text()->notNull(),

            //optional extra notes
            'notes'=>$this->text()->null(),

            //timestamps for record keeping
            'created_at'=>$this->integer()->notNUll(),
            'updated_at'=>$this->integer()->notNUll(),
        ]);

        //add foreign key to user table
        $this->addForeignKey(
            'fk-journal-user_id',
            '{{%journal}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%journal}}');
        $this->dropForeignKey('fk-journal-user_id', '{{%journal}}');
    }
}
