<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\Goal;
use common\models\Achievement;
use common\models\Checkin;
use common\models\Journal;

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
    // 1. Identify the authenticated user.
    $user = Yii::$app->user->identity;

    // 2. Get today's date.
    $today = date('Y-m-d');

    // 3. Prevent duplicate check-ins.
    $alreadyCheckedIn = Checkin::find()
        ->where([
            'user_id' => $user->id,
            'checkin_date' => $today,
        ])
        ->exists();

    if ($alreadyCheckedIn) {
        return [
            'success' => false,
            'message' => 'You have already checked in today. Come back tomorrow!',
        ];
    }

    // 4. Create the new check-in.
    $checkin = new Checkin();
    $checkin->user_id = $user->id;
    $checkin->checkin_date = $today;
    $checkin->created_at = time();

    // 5. Save the check-in.
    if (!$checkin->save()) {
        Yii::$app->response->statusCode = 500;

        return [
            'success' => false,
            'message' => 'Unable to save your check-in. Please try again.',
            'errors' => $checkin->errors,
        ];
    }

    // 6. Retrieve the user's check-in history, newest first.
    $checkins = Checkin::find()
        ->where(['user_id' => $user->id])
        ->orderBy(['checkin_date' => SORT_DESC])
        ->all();

    // 7. Calculate the current consecutive streak.
    $streak = 0;
    $expectedDate = $today;

    foreach ($checkins as $record) {
        if ($record->checkin_date === $expectedDate) {
            $streak++;

            $expectedDate = date(
                'Y-m-d',
                strtotime($expectedDate . ' -1 day')
            );
        } else {
            break;
        }
    }

    // 8. Update goals reached by the current streak.
    Goal::updateCompletedGoals(
        $user->id,
        $streak
    );

    // 9. Unlock achievements earned through this streak.
    Achievement::unlockForStreak(
        $user->id,
        $streak
    );

    // 10. Return the successful result to the mobile app.
    return [
        'success' => true,
        'message' => 'Your daily check-in is complete. Keep going!',
        'checkin' => [
            'id' => $checkin->id,
            'date' => $checkin->checkin_date,
            'created_at' => $checkin->created_at,
        ],
        'streak' => $streak,
    ];
}

/**
 * Return the authenticated user's journal entries.
 * GET /site/journals
 */
public function actionJournals()
{
    // Identify the authenticated user.
    $user = Yii::$app->user->identity;

    // Retrieve only this user's journal entries.
    $entries = Journal::find()
        ->where(['user_id' => $user->id])
        ->orderBy(['entry_date' => SORT_DESC])
        ->all();

    // Prepare the entries for the mobile application.
    $data = [];

    foreach ($entries as $entry) {
        $data[] = [
            'id' => $entry->id,
            'entry_date' => $entry->entry_date,
            'temptation_type' => $entry->temptation_type,
            'intensity' => $entry->intensity,
            'what_happened' => $entry->what_happened,
            'how_responded' => $entry->how_responded,
            'notes' => $entry->notes,
        ];
    }

    return [
        'success' => true,
        'total' => count($data),
        'entries' => $data,
    ];
}


/**
 * Create a journal entry for the authenticated user.
 * POST /site/journals
 */
public function actionCreateJournal()
{
    // 1. Identify the authenticated user.
    $user = Yii::$app->user->identity;

   // 2. Read and decode the JSON data sent by the mobile app.
$data = json_decode(
    Yii::$app->request->getRawBody(),
    true
);

// Make sure the request contains valid JSON.
if (!is_array($data)) {
    Yii::$app->response->statusCode = 400;

    return [
        'success' => false,
        'message' => 'Invalid JSON request data.',
    ];
}

    // 3. Create a new Journal model.
    $journal = new Journal();

    // 4. Assign the authenticated user's ID.
    // Never trust the user_id sent by the mobile app.
    $journal->user_id = $user->id;

    // 5. Assign the journal information.
    $journal->entry_date = $data['entry_date'] ?? date('Y-m-d');
    $journal->temptation_type = trim($data['temptation_type'] ?? '');
    $journal->intensity = $data['intensity'] ?? null;
    $journal->what_happened = trim($data['what_happened'] ?? '');
    $journal->how_responded = trim($data['how_responded'] ?? '');
    $journal->notes = isset($data['notes'])
        ? trim($data['notes'])
        : null;

    // 6. Generate timestamps on the server.
    $journal->created_at = time();
    $journal->updated_at = time();

    // 7. Validate the intensity range (1–10).
    if (
        !is_numeric($journal->intensity) ||
        (int) $journal->intensity < 1 ||
        (int) $journal->intensity > 10
    ) {
        Yii::$app->response->statusCode = 422;

        return [
            'success' => false,
            'message' => 'Intensity must be a number between 1 and 10.',
        ];
    }

    // Store intensity as an integer.
    $journal->intensity = (int) $journal->intensity;

    // 8. Validate and save the journal entry.
    if (!$journal->save()) {
        Yii::$app->response->statusCode = 422;

        return [
            'success' => false,
            'message' => 'Unable to save your journal entry.',
            'errors' => $journal->errors,
        ];
    }

    // 9. Return the saved entry to the mobile app.
    return [
        'success' => true,
        'message' => 'Your journal entry has been saved successfully!',
        'entry' => [
            'id' => $journal->id,
            'entry_date' => $journal->entry_date,
            'temptation_type' => $journal->temptation_type,
            'intensity' => $journal->intensity,
            'what_happened' => $journal->what_happened,
            'how_responded' => $journal->how_responded,
            'notes' => $journal->notes,
        ],
    ];

}


/**
 * Update an existing journal entry.
 * PUT /site/journals/{id}
 */
public function actionUpdateJournal($id)
{
    // 1. Identify the authenticated user.
    $user = Yii::$app->user->identity;

    // 2. Find the journal entry belonging to this user.
    $journal = Journal::find()
        ->where([
            'id' => $id,
            'user_id' => $user->id,
        ])
        ->one();

    // 3. Stop if the entry does not exist or belongs to another user.
    if ($journal === null) {
        Yii::$app->response->statusCode = 404;

        return [
            'success' => false,
            'message' => 'Journal entry not found.',
        ];
    }

    // 4. Read the JSON request body.
    $data = json_decode(
        Yii::$app->request->getRawBody(),
        true
    );

    if (!is_array($data)) {
        Yii::$app->response->statusCode = 400;

        return [
            'success' => false,
            'message' => 'Invalid JSON request data.',
        ];
    }

    // 5. Update only the fields supplied by the mobile app.
    if (array_key_exists('entry_date', $data)) {
        $journal->entry_date = $data['entry_date'];
    }

    if (array_key_exists('temptation_type', $data)) {
        $journal->temptation_type = trim($data['temptation_type']);
    }

    if (array_key_exists('intensity', $data)) {
        $journal->intensity = $data['intensity'];
    }

    if (array_key_exists('what_happened', $data)) {
        $journal->what_happened = trim($data['what_happened']);
    }

    if (array_key_exists('how_responded', $data)) {
        $journal->how_responded = trim($data['how_responded']);
    }

    if (array_key_exists('notes', $data)) {
        $journal->notes = $data['notes'] !== null
            ? trim($data['notes'])
            : null;
    }

    // 6. Validate intensity if it was supplied.
    if (
        !is_numeric($journal->intensity) ||
        (int) $journal->intensity < 1 ||
        (int) $journal->intensity > 10
    ) {
        Yii::$app->response->statusCode = 422;

        return [
            'success' => false,
            'message' => 'Intensity must be a number between 1 and 10.',
        ];
    }

    $journal->intensity = (int) $journal->intensity;

    // 7. Update the modification timestamp.
    $journal->updated_at = time();

    // 8. Validate and save the changes.
    if (!$journal->save()) {
        Yii::$app->response->statusCode = 422;

        return [
            'success' => false,
            'message' => 'Unable to update your journal entry.',
            'errors' => $journal->errors,
        ];
    }

    // 9. Return the updated journal entry.
    return [
        'success' => true,
        'message' => 'Your journal entry has been updated successfully!',
        'entry' => [
            'id' => $journal->id,
            'entry_date' => $journal->entry_date,
            'temptation_type' => $journal->temptation_type,
            'intensity' => $journal->intensity,
            'what_happened' => $journal->what_happened,
            'how_responded' => $journal->how_responded,
            'notes' => $journal->notes,
        ],
    ];
}



/**
 * Delete an existing journal entry.
 * DELETE /site/journals/{id}
 */
public function actionDeleteJournal($id)
{
    // 1. Identify the authenticated user.
    $user = Yii::$app->user->identity;

    // 2. Find the entry belonging to this user.
    $journal = Journal::find()
        ->where([
            'id' => $id,
            'user_id' => $user->id,
        ])
        ->one();

    // 3. Stop if the entry doesn't exist or belongs to another user.
    if ($journal === null) {
        Yii::$app->response->statusCode = 404;

        return [
            'success' => false,
            'message' => 'Journal entry not found.',
        ];
    }

    // 4. Delete the journal entry.
    if ($journal->delete() === false) {
        Yii::$app->response->statusCode = 500;

        return [
            'success' => false,
            'message' => 'Unable to delete your journal entry.',
        ];
    }

    // 5. Confirm successful deletion.
    return [
        'success' => true,
        'message' => 'Your journal entry has been deleted successfully!',
    ];
}


}
