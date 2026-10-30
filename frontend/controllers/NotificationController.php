<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\NotificationPreference;
use common\models\Notification;

class NotificationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['preferences','index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionPreferences()
    {
        $userId = Yii::$app->user->id;

        $preferences = NotificationPreference::getForUser($userId);

        if ($preferences === null) {
            throw new \yii\web\ServerErrorHttpException(
                'Unable to load notification preferences. Please try again.'
            );
        }

        return $this->render('preferences', [
            'preferences' => $preferences,
        ]);
    }

    
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $notifications = Notification::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(50)
            ->all();

        return $this->render('index', [
            'notifications' => $notifications,
        ]);
    }

}
