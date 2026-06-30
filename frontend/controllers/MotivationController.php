<?php

namespace frontend\controllers;
use yii\filters\AccessControl;

class MotivationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function behaviors(){
        return[
            'access'=>[
                'class'=> AccessControl::class,
                'only'=>['index'],
                'rules'=>[
                    [
                        'actions'=>['index'],
                        'allow'=>true,
                        'roles'=>['@'],
                    ],
                ],
            ],
        ];
    }

    /**
 * Displays the Emergency Help page.
 *
 * This page provides encouragement and practical steps
 * for users who are struggling with temptation.
 */
public function actionEmergency()
{
    return $this->render('emergency');
}
}
