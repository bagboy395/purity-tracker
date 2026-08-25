<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "achievements".
 *
 * @property int $id
 * @property int $user_id
 * @property string $achievement
 * @property int $days
 * @property string $unlocked_at
 *
 * @property User $user
 */
class Achievement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'achievement', 'days', 'unlocked_at'], 'required'],
            [['user_id', 'days'], 'integer'],
            [['unlocked_at'], 'safe'],
            [['achievement'], 'string', 'max' => 100],

            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
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
            'achievement' => 'Achievement',
            'days' => 'Days',
            'unlocked_at' => 'Unlocked At',
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

    public static function unlockForStreak($userId, $streak)
{
    $milestones = [
        1 => 'First Step',
        3 => 'Building Momentum',
        7 => 'One Week Strong',
        14 => 'Two Weeks Strong',
        30 => 'One Month Strong',
        60 => '60-Day Champion',
        90 => '90-Day Master',
    ];

    foreach ($milestones as $days => $achievementName) {

        if ($streak >= $days) {

            // Check if this achievement has already been unlocked
            $exists = self::find()
                ->where([
                    'user_id' => $userId,
                    'achievement' => $achievementName,
                ])
                ->exists();

            // Only create it if it doesn't already exist
            if (!$exists) {

                $achievement = new self();

                $achievement->user_id = $userId;
                $achievement->achievement = $achievementName;
                $achievement->days = $days;
                $achievement->unlocked_at = date('Y-m-d H:i:s');

                $achievement->save(false);
            }
        }
    }
}
}