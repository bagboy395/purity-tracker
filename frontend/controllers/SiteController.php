<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Checkin;
use common\models\Achievement;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //request data from checkins table
        $checkins= Checkin::find()
        ->where(['user_id'=>Yii::$app->user->id])
        ->orderBy(['checkin_date'=>SORT_DESC])
        ->all();
        $totalCheckins = count($checkins);

        //get if user has checked in with a record yet for today
        $today = date('Y-m-d');
        $hasCheckedInToday = Checkin::find()
        ->where([
            'user_id'=> Yii::$app->user->id,
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
// Daily motivation quotes
$quotes = [
    'Small disciplines repeated daily create extraordinary results.',
    'Success is the sum of small efforts repeated day after day.',
    'You do not rise to the level of your goals. You fall to the level of your systems.',
    'Every day you stay consistent, you strengthen your future self.',
    'Progress is built one day at a time.',
    'A setback is not the end. Start again today.',
];

// Pick a random quote
$dailyQuote = $quotes[array_rand($quotes)];


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
          'dailyQuote'=>$dailyQuote,
          'totalCheckins'=>$totalCheckins,
          'longestStreak'=>$longestStreak,
        ]);

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionJournal()
{
    return $this->render('journal');
}

public function actionMotivation()
{
    return $this->render('motivation');
}

public function actionGoals()
{
    return $this->render('goals');
}

public function actionAchievements()
{
    // Get the logged-in user's check-ins
    $checkins = Checkin::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->orderBy(['checkin_date' => SORT_DESC])
        ->all();

    // Calculate current streak
    $streak = 0;

    $expectedDate = date('Y-m-d');

    foreach ($checkins as $checkin) {

        if ($checkin->checkin_date == $expectedDate) {

            $streak++;

            $expectedDate = date(
                'Y-m-d',
                strtotime($expectedDate . ' -1 day')
            );

        } else {

            break;
        }
    }

    // Get achievements already unlocked by this user
$achievements = Achievement::find()
    ->where(['user_id' => Yii::$app->user->id])
    ->orderBy(['days' => SORT_ASC])
    ->all();

return $this->render('achievements', [
    'streak' => $streak,
    'achievements' => $achievements,
]);

}
}
