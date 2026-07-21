<?php

namespace frontend\controllers;
use yii\filters\AccessControl;
use common\models\Quote;

class MotivationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //ask the model for one random quote
        $quote = Quote::getRandomActiveQuote();

        //pass the quote to the view
        return $this->render('index',[
           'quote'=>$quote,
        ]);
        
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
