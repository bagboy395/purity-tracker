<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Goal;
use frontend\models\GoalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Checkin;

/**
 * GoalController implements the CRUD actions for Goal model.
 */
class GoalController extends Controller
{
    /**
     * @inheritDoc
     */
 public function behaviors()
{
    return array_merge(
        parent::behaviors(),
        [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]
    );
}

    /**
     * Lists all Goal models.
     *
     * @return string
     */
   public function actionIndex()
{
    $searchModel = new GoalSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    // Get the user's check-ins from newest to oldest
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

    // Get the milestone for the current streak
$milestone = Goal::getMilestone($streak);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'streak' => $streak,
        'milestone' => $milestone,
    ]);
}

    /**
     * Displays a single Goal model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
        public function actionCreate()
{
    $model = new Goal();

    if ($this->request->isPost) {

        if ($model->load($this->request->post())) {

            $model->user_id = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            }
        }

    } else {
        $model->loadDefaultValues();
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}
    

    /**
     * Updates an existing Goal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Goal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Goal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goal::find()
    ->where([
        'id' => $id,
        'user_id' => Yii::$app->user->id,
    ])
    ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
}
