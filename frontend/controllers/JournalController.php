<?php

namespace frontend\controllers;

use Yii;
use common\models\Journal;
use frontend\models\JournalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * JournalController implements the CRUD actions for Journal model.
 */
class JournalController extends Controller
{
    /**
     * Behaviors:
     * - AccessControl: only logged-in users can access journal pages
     * - VerbFilter: journal delete can only happen via POST request
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                // Restrict journal pages to authenticated users only
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],

                // Prevent deleting entries by simple URL GET request
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists the current logged-in user's journal entries only.
     */
    public function actionIndex()
    {
        $searchModel = new JournalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // IMPORTANT:
        // Force the list to only show journal entries belonging to the current user
        $dataProvider->query->andWhere([
            'user_id' => Yii::$app->user->id
        ]);

        //sort newest journal entries first
        $dataProvider->query->orderBy(['entry_date'=>SORT_DESC]);

        //get all crrent users journal entries
        $journals = Journal::find()
        ->where(['user_id'=> Yii::$app->user->id])
        ->orderBy(['entry_date'=>SORT_DESC])
        ->all();

        //Total number of journal entries
        $totalEntries = count($journals);

        //calculate average intensity
        $averageIntensity = 0;
        if ($totalEntries > 0 ){
            $sum= 0;
            foreach($journals as $journal){
                $sum += (int)$journal->intensity;
            }
            $averageIntensity = round($sum / $totalEntries, 1);
        }

        //GEt latest journal entry date
        $latestEntryDate = null;
        if (!empty($journals)){
            $latestEntryDate=$journals[0]->entry_date;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalEntries' => $totalEntries,
            'averageIntensity' => $averageIntensity,
            'latestEntryDate' => $latestEntryDate,
            'journals' => $journals,
        ]);
    }

    /**
     * Displays a single journal entry.
     * The findModel() method below will make sure the entry belongs to the current user.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new journal entry.
     * We auto-fill system fields instead of asking the user to type them.
     */
    public function actionCreate()
    {
        $model = new Journal();

        if ($this->request->isPost && $model->load($this->request->post())) {

            // Auto-assign the journal entry to the currently logged-in user
            $model->user_id = Yii::$app->user->id;

            // Set created/updated timestamps
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing journal entry.
     * Also refreshes updated_at timestamp when saved.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            // Update the "last modified" timestamp
            $model->updated_at = time();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing journal entry.
     * Since findModel() is user-protected, users can only delete their own entries.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds a journal model by ID, but ONLY if it belongs to the current logged-in user.
     * This prevents users from accessing another user's journal entry by changing the URL.
     */
    protected function findModel($id)
    {
        $model = Journal::find()
            ->where([
                'id' => $id,
                'user_id' => Yii::$app->user->id,
            ])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested journal entry does not exist.');
    }
}