<?php

namespace common\models;

use Yii;
use common\models\Achievement;

/**
 * This is the model class for table "goals".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property int $target_days
 * @property string $created_at
 * @property int|null $is_completed
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Goal extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'updated_at'], 'default', 'value' => null],
            [['is_completed'], 'default', 'value' => 0],
            [['user_id', 'title', 'target_days'], 'required'],
            [['user_id', 'target_days', 'is_completed'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'description' => 'Description',
            'target_days' => 'Target Days',
            'created_at' => 'Created At',
            'is_completed' => 'Is Completed',
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

    public static function updateCompletedGoals($userId, $currentStreak)
{
    $goals = self::find()
        ->where([
            'user_id' => $userId,
            'is_completed' => 0,
        ])
        ->andWhere(['<=', 'target_days', $currentStreak])
        ->all();

    foreach ($goals as $goal) {
        $goal->is_completed = 1;
        $goal->save(false);
    }
}


public static function getMilestone($streak)
{
    if ($streak >= 90) {
        return [
            'title' => '90-Day Master',
            'message' => '🥇 Incredible! You have reached 90 days!',
        ];
    }

    if ($streak >= 60) {
        return [
            'title' => '60-Day Champion',
            'message' => '🚀 Amazing! You have reached 60 days!',
        ];
    }

    if ($streak >= 30) {
        return [
            'title' => 'One Month Strong',
            'message' => '👑 One full month of consistency!',
        ];
    }

    if ($streak >= 14) {
        return [
            'title' => 'Two Weeks Strong',
            'message' => '💪 Two weeks! Keep building!',
        ];
    }

    if ($streak >= 7) {
        return [
            'title' => 'One Week Strong',
            'message' => '🏆 You have completed one full week!',
        ];
    }

    if ($streak >= 3) {
        return [
            'title' => 'Building Momentum',
            'message' => '🔥 Three days strong! Keep going!',
        ];
    }

    if ($streak >= 1) {
        return [
            'title' => 'First Step',
            'message' => '🌱 You have taken the first step!',
        ];
    }

    return null;
}


public static function unlockAchievement($userId, $streak)
{
    $milestone = self::getMilestone($streak);

    // No milestone reached yet
    if ($milestone === null) {
        return;
    }

    // Check if this achievement has already been unlocked
    $existingAchievement = Achievement::find()
        ->where([
            'user_id' => $userId,
            'achievement' => $milestone['title'],
        ])
        ->exists();

    // Don't create duplicates
    if ($existingAchievement) {
        return;
    }

    // Create the achievement record
    $achievement = new Achievement();

    $achievement->user_id = $userId;
    $achievement->achievement = $milestone['title'];
    $achievement->days = $streak;
    $achievement->unlocked_at = date('Y-m-d H:i:s');

    $achievement->save(false);
}




}
