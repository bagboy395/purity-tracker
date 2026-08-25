<?php

namespace frontend\controllers;
use yii\web\Controller;
use common\models\Checkin;
use Yii;
use yii\filters\AccessControl;
use common\models\Goal;

class CheckinController extends \yii\web\Controller
{
    public function actionIndex()
    {

    //requesting checkin data from database
    $checkins = Checkin::find()
    ->where(['user_id'=>Yii::$app->user->id])
    ->orderBy(['checkin_date' => SORT_DESC])
    ->all();

    //requesting total checkin data of a user
    $totalCheckins = Checkin::find()
    ->where(['user_id' => Yii::$app->user->id])
    ->count();

//has this user already checked in today
$today = date('Y-m-d');

$hasCheckedInToday = Checkin::find()
          ->where([
            'user_id'=>Yii::$app->user->id,
            'checkin_date'=> $today
          ])
          ->exists();

// 1. Initialize the counter
$streak = 0;

// 2. Determine where to start checking
$expectedDate = $hasCheckedInToday ? date('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

// 3. Loop through past check-ins
foreach ($checkins as $checkin) {
    // 4. Check if this record matches our target date
    if ($checkin->checkin_date == $expectedDate) {
        $streak++; // Increment streak
        
        // 5. Move the target back by 1 day
        $expectedDate = date('Y-m-d', strtotime($expectedDate . ' -1 day'));
    } else {
        // 6. Break the loop if a day is missing
        break;
    }
 

    } 

    //implementing longest streak calculation
    $longestStreak = 0;

    //stores streak we are currently counting
    $currentRun = 0;
    
    //get all checkins from Oldest to Newest in chronological order to detect consecutive days 
    $ascendingCheckins = Checkin::find()
    ->where(['user_id'=>Yii::$app->user->id])
    ->orderBy(['checkin_date'=>SORT_ASC])
    ->all();

    //used to remember previous checkin date
    $previousDate = null;

    //loop through every check-in
    foreach($ascendingCheckins as $checkin){
        if($previousDate == null){

        //a single checkin starts a streak of 1
            $currentRun = 1;
        }else{

        //calculate what date should come next 
            $expectedNextDay = date('Y-m-d', strtotime($previousDate.'+1 day')
            );

            //if todays record is exactly the next day
            if($checkin->checkin_date === $expectedNextDay){
                $currentRun++;
            } else{

            //if gap detected, reset streak and start again from 1
                $currentRun = 1;
            }
        }

        //if current streak beats our previous record, record as newest longest streak
        if ($currentRun > $longestStreak){
            $longestStreak = $currentRun;
        }
        $previousDate = $checkin->checkin_date;
    }


        return $this->render('index',
        ['checkins'=>$checkins,
          'streak'=> $streak,
          'hasCheckedInToday'=>$hasCheckedInToday,
          'totalCheckins'=> $totalCheckins,
          'longestStreak'=> $longestStreak,
        ]);
    }   

    public function actionCreate()
    {
        //prevent duplication of checkin records in a day 
        $existingCheckin = Checkin::find()->where([
            'user_id'=> Yii::$app->user->id,
            'checkin_date'=> date('Y-m-d')
        ]) 
        -> one();
        if ($existingCheckin){
            Yii::$app->session->setFlash('error',
            'You already checked in today.');
            return $this->redirect(['checkin/index']);
        }
//action save new checkin
        $checkin = new Checkin();

        $checkin->user_id = Yii::$app->user->id;
        $checkin->checkin_date = date('Y-m-d');
        $checkin->created_at = time();

        if ($checkin->save()) {

    // Calculate the user's current streak
    $checkins = Checkin::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->orderBy(['checkin_date' => SORT_DESC])
        ->all();

    $streak = 0;

    $expectedDate = date('Y-m-d');

    foreach ($checkins as $checkinRecord) {

        if ($checkinRecord->checkin_date == $expectedDate) {

            $streak++;

            $expectedDate = date(
                'Y-m-d',
                strtotime($expectedDate . ' -1 day')
            );

        } else {

            break;
        }
    }

    // Check whether any goals have been reached
    Goal::updateCompletedGoals(
        Yii::$app->user->id,
        $streak
    );

    Yii::$app->session->setFlash(
        'success',
        'Check-in successful!'
    );

} else {

    Yii::$app->session->setFlash(
        'error',
        'Unable to save your check-in.'
    );
}

return $this->redirect(['checkin/index']);

    }

public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => ['index', 'create'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
    ];
}

}
