<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Model for the notifications table.
 */
class Notification extends ActiveRecord
{
    /**
     * Connects this model to the notifications table.
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * Validates notification data before saving.
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'message'], 'required'],

            [['user_id', 'is_read', 'created_at'], 'integer'],

            [['message'], 'string'],

            [['title'], 'string', 'max' => 150],

            [['type'], 'string', 'max' => 50],

            ['type', 'default', 'value' => 'general'],

            ['is_read', 'default', 'value' => 0],

            ['created_at', 'default', 'value' => time()],

            [
                'user_id',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
                'skipOnError' => true,
            ],
        ];
    }

    /**
     * Gets the user who owns this notification.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Counts unread notifications for a specific user.
     */
    public static function getUnreadCount($userId)
    {
        return static::find()
            ->where([
                'user_id' => $userId,
                'is_read' => 0,
            ])
            ->count();
    }

    /**
     * Marks this notification as read.
     */
    public function markAsRead()
    {
        if ((int) $this->is_read === 1) {
            return true;
        }

        $this->is_read = 1;

        return $this->save(false, ['is_read']);
    }

    
/**
 * Creates a notification only when the user has enabled
 * the corresponding notification preference.
 *
 * Supported types:
 * achievement, goal, streak, motivation, scripture,
 * checkin_reminder, general
 */
public static function createForUser($userId, $title, $message, $type = 'general')
{
    $preferences = NotificationPreference::getForUser($userId);

    if ($preferences === null) {
        return false;
    }

    // Respect the master notification switch.
    if (!(int) $preferences->notifications_enabled) {
        return false;
    }

    // Map each notification type to its preference column.
    $preferenceMap = [
        'achievement' => 'achievement_notifications',
        'goal' => 'goal_notifications',
        'streak' => 'streak_notifications',
        'motivation' => 'motivation_notifications',
        'scripture' => 'scripture_notifications',
        'checkin_reminder' => 'checkin_reminders',
    ];

    if (isset($preferenceMap[$type])) {
        $preferenceColumn = $preferenceMap[$type];

        if (!(int) $preferences->$preferenceColumn) {
            return false;
        }
    }

    $notification = new self();
    $notification->user_id = $userId;
    $notification->title = $title;
    $notification->message = $message;
    $notification->type = $type;
    $notification->is_read = 0;
    $notification->created_at = time();

    return $notification->save();
}

}
