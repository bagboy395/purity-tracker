<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ServerErrorHttpException;
use common\models\User;
use common\models\NotificationPreference;
use frontend\models\ProfileForm;
use frontend\models\ChangePasswordForm;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        $profileModel = new ProfileForm($user);
        $passwordModel = new ChangePasswordForm($user);

        $preferences = NotificationPreference::getForUser(
            Yii::$app->user->id
        );

        if ($preferences === null) {
            throw new ServerErrorHttpException(
                'Unable to load notification preferences. Please try again.'
            );
        }

        // Handle profile updates.
        if (
            Yii::$app->request->isPost &&
            Yii::$app->request->post('formType') === 'profile'
        ) {
            if (
                $profileModel->load(Yii::$app->request->post()) &&
                $profileModel->save()
            ) {
                Yii::$app->session->setFlash(
                    'success',
                    'Your profile has been updated successfully.'
                );

                return $this->redirect(['index']);
            }
        }

        // Handle password changes.
        if (
            Yii::$app->request->isPost &&
            Yii::$app->request->post('formType') === 'password'
        ) {
            if (
                $passwordModel->load(Yii::$app->request->post()) &&
                $passwordModel->changePassword()
            ) {
                Yii::$app->session->setFlash(
                    'success',
                    'Your password has been changed successfully.'
                );

                return $this->redirect(['index']);
            }
        }

        // Handle notification preference updates.
        if (
            Yii::$app->request->isPost &&
            Yii::$app->request->post('formType') === 'notifications'
        ) {
            $post = Yii::$app->request->post(
                'NotificationPreference',
                []
            );

            $fields = [
                'notifications_enabled',
                'achievement_notifications',
                'goal_notifications',
                'streak_notifications',
                'motivation_notifications',
                'scripture_notifications',
                'checkin_reminders',
            ];

            foreach ($fields as $field) {
                $preferences->$field = isset($post[$field]) ? 1 : 0;
            }

            if ($preferences->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    'Your notification preferences have been saved.'
                );

                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash(
                'error',
                'Unable to save your notification preferences. Please try again.'
            );
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $profileModel,
            'passwordModel' => $passwordModel,
            'preferences' => $preferences,
        ]);
    }
}