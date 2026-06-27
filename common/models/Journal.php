<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id
 * @property int $user_id
 * @property string $entry_date
 * @property string $temptation_type
 * @property int $intensity
 * @property string $what_happened
 * @property string $how_responded
 * @property string|null $notes
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Journal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'default', 'value' => null],
            [['user_id', 'entry_date', 'temptation_type', 'intensity', 'what_happened', 'how_responded', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'intensity', 'created_at', 'updated_at'], 'integer'],
            [['entry_date'], 'safe'],
            [['what_happened', 'how_responded', 'notes'], 'string'],
            [['temptation_type'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'entry_date' => 'Entry Date',
            'temptation_type' => 'Temptation Type',
            'intensity' => 'Intensity',
            'what_happened' => 'What Happened',
            'how_responded' => 'How Responded',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
