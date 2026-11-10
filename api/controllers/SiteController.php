<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

class SiteController extends Controller
{
    /**
     * Configure authentication for API endpoints.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Authenticate API requests using Bearer tokens.
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,

            // Login and API test endpoints don't require authentication.
            'except' => ['index', 'login'],
        ];

        return $behaviors;
    }

    /**
     * Test endpoint to confirm the API is running.
     * GET /site/index
     */
    public function actionIndex()
    {
        // Test whether the API can communicate with the database.
        try {
            Yii::$app->db->open();

            return [
                'success' => true,
                'message' => 'Purity Tracker API is running!',
                'database' => 'Connected successfully!',
                'version' => '1.0',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'API is running, but database connection failed.',
            ];
        }
    }

    /**
     * Mobile app login endpoint.
     * POST /site/login
     */
     public function actionLogin()
    {
        // Get the username and password sent by the mobile app.
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        // Find the user by username.
        $user = \common\models\User::findByUsername($username);

        // Verify that the user exists and the password is correct.
        if (!$user || !$user->validatePassword($password)) {
            return [
                'success' => false,
                'message' => 'Invalid username or password.',
            ];
        }

        // Generate a secure random API token.
        $user->api_token = Yii::$app->security->generateRandomString(64);

        // Save the token in the database.
        if (!$user->save(false)) {
            return [
                'success' => false,
                'message' => 'Could not generate login token.',
            ];
        }

        // Return the token to the mobile app.
        return [
            'success' => true,
            'message' => 'Login successful!',
            'token' => $user->api_token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ];
    }

    /**
     * Return the profile of the authenticated user.
     * GET /site/profile
     */
    public function actionProfile()
    {
        // Yii identifies the user using their Bearer token.
        $user = Yii::$app->user->identity;

        return [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ];
    }

    /**
     * Return the authenticated user's check-in history.
     * GET /site/checkins
     */
    public function actionCheckins()
    {
        // Get the currently authenticated user.
        $user = Yii::$app->user->identity;

        // Retrieve only this user's check-ins, newest first.
        $checkins = \common\models\Checkin::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['checkin_date' => SORT_DESC])
            ->all();

        // Prepare the check-in data for the mobile app.
        $data = [];

        foreach ($checkins as $checkin) {
            $data[] = [
                'id' => $checkin->id,
                'date' => $checkin->checkin_date,
                'created_at' => $checkin->created_at,
            ];
        }

        return [
            'success' => true,
            'total' => count($data),
            'checkins' => $data,
        ];
    }

    /**
     * Create a daily check-in for the authenticated user.
     * POST /site/checkin
     */
    public function actionCreateCheckin()
    {
        // 1. Identify the authenticated user through their API token.
        $user = Yii::$app->user->identity;

        // 2. Get today's date in YYYY-MM-DD format.
        $today = date('Y-m-d');

        // 3. Check whether this user has already checked in today.
        $alreadyCheckedIn = \common\models\Checkin::find()
            ->where([
                'user_id' => $user->id,
                'checkin_date' => $today,
            ])
            ->exists();

        // 4. Prevent duplicate check-ins on the same day.
        if ($alreadyCheckedIn) {
            return [
                'success' => false,
                'message' => 'You have already checked in today. Come back tomorrow!',
            ];
        }

        // 5. Create a new Checkin model object.
        $checkin = new \common\models\Checkin();

        // 6. Assign the values required by the Checkin model.
        $checkin->user_id = $user->id;
        $checkin->checkin_date = $today;
        $checkin->created_at = time();

        // 7. Validate and save the check-in to the database.
        if (!$checkin->save()) {
            Yii::$app->response->statusCode = 500;

            return [
                'success' => false,
                'message' => 'Unable to save your check-in. Please try again.',
                'errors' => $checkin->errors,
            ];
        }

        // 8. Return the successful result to the mobile app.
        return [
            'success' => true,
            'message' => 'Your daily check-in is complete. Keep going!',
            'checkin' => [
                'id' => $checkin->id,
                'date' => $checkin->checkin_date,
                'created_at' => $checkin->created_at,
            ],
        ];
    }
}
