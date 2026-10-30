<?php

namespace common\models;

use yii\db\ActiveRecord;

class NotificationPreference extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%notification_preferences}}';
    }

    public function rules()
    {
        return [
            [[
                'user_id',
                'notifications_enabled',
                'achievement_notifications',
                'goal_notifications',
                'streak_notifications',
                'motivation_notifications',
                'scripture_notifications',
                'checkin_reminders',
                'created_at',
                'updated_at',
            ], 'integer'],

            [['user_id'], 'required'],

            [
                ['user_id'],
                'unique',
                'targetAttribute' => 'user_id',
            ],

            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = time();

        if ($insert) {
            $this->created_at = $now;
        }

        $this->updated_at = $now;

        return true;
    }

    /**
     * Gets a user's notification preferences.
     * Creates default preferences if none exist.
     */
    public static function getForUser($userId)
    {
        $preferences = self::findOne(['user_id' => $userId]);

        if ($preferences !== null) {
            return $preferences;
        }

        $preferences = new self();
        $preferences->user_id = $userId;

        return $preferences->save() ? $preferences : null;
    }
}
