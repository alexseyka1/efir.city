<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Messages;
use app\modules\admin\models\MessagesSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin;
                        }
                    ],
                ]
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],*/
        ];
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "main";
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = "main";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "main";
        $model = new Messages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Messages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "main";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Messages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionStat(){
        $this->layout = "main";
        try {
            /*$subQuery = (new Query())
                ->select('c.city_id,c.name,c.region_id,COUNT(m.id) AS count_messages')
                ->from('messages m')
                ->leftJoin('city c', 'm.city_id = c.city_id')
                ->orderBy(['c.region_id' => SORT_DESC])
                ->groupBy('c.city_id');
            $query = (new Query())
                ->select('r.region_id,r.name as region_name,cat.city_id,cat.name,cat.count_messages')
                ->from(['cat' => $subQuery])
                ->leftJoin('region r', 'cat.region_id = r.region_id')
                ->all();*/
            $sql = "
                SELECT
                  r.region_id,
                  r.name as region_name,
                  cat.city_id,
                  cat.name,
                  cat.messages_day,
                  cat.messages_yesterday,
                  cat.messages_week,
                  cat.messages_month,
                  cat.messages_all
                FROM (
                  SELECT
                    c.city_id,
                    c.name,
                    c.region_id,
                    (
                      SELECT
                        COUNT(id) as mess_day
                        FROM workslimfr.messages m2
                      WHERE m2.city_id = c.city_id
                      AND DATE(m2.post_datetime) = DATE(NOW())
                    ) as messages_day,
                    (
                      SELECT
                        COUNT(id) as mess_day
                        FROM workslimfr.messages m2
                      WHERE m2.city_id = c.city_id
                      AND DATE(m2.post_datetime) = DATE(NOW() - INTERVAL 1 DAY)
                    ) as messages_yesterday,
                    (
                      SELECT
                        COUNT(id) as mess_day
                        FROM workslimfr.messages m2
                      WHERE m2.city_id = c.city_id
                      AND DATE(m2.post_datetime) >= DATE(NOW() - INTERVAL 7 DAY)
                    ) as messages_week,
                    (
                      SELECT
                        COUNT(id) as mess_day
                        FROM workslimfr.messages m2
                      WHERE m2.city_id = c.city_id
                      AND DATE(m2.post_datetime) >= DATE(NOW() - INTERVAL 30 DAY)
                    ) as messages_month,
                    COUNT(m.id) AS messages_all
                  FROM workslimfr.messages m
                    LEFT JOIN workslimfr.city c ON m.city_id = c.city_id
                    WHERE m.is_paid = 1
                  GROUP BY c.city_id
                ) cat
                LEFT JOIN workslimfr.region r ON cat.region_id = r.region_id
            ";
            $query = \Yii::$app->db->createCommand($sql)->queryAll();
            if(!$query){
                throw new \Exception('Не удалось выбрать из бд регионы');
            }else{
                $regions = [];
                foreach ($query as $key => $region) {
                    $regions[$region['region_id']][] = $region;
                }
                return $this->render('stat', ['q' => $regions]);   
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
