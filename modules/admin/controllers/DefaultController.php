<?php

namespace app\modules\admin\controllers;

use yii\db\Query;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;

/**
 * Default controller for the `Admin` module
 */
class DefaultController extends Controller
{

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$this->layout = 'main';
        return $this->render('index');
    }

    public function actionSsh(){
        $data = [];
        if(!empty($_POST)){
            $data = ['post' => $_POST];
        }
        $this->layout = 'main';
        return $this->render('command', $data);
    }

    public function actionLasttenmessages(){
        $countAll = (new Query())->select('COUNT(*) as count')->from('messages')->one();
        $countPaid = (new Query())->select('COUNT(*) as count')->from('messages')->where('is_paid=1')->one();
        $countPublished = (new Query())->select('COUNT(*) as count')->from('messages')->where('is_published=1')->one();
        
        try {
            $sql = "
                SELECT
                  c.city_id, c.name, COUNT(id) as max
                FROM workslimfr.city c
                LEFT JOIN workslimfr.messages m ON m.city_id = c.city_id
                GROUP BY c.name
                HAVING max > 0
                ORDER BY max DESC
                LIMIT 3
            ";
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            if(!$result){
                throw new \Exception('Не удалось определить популярные города!');
            }else{
                $popularCities = $result;
            }
        }catch (\Exception $e){
            $popularCities = $e->getMessage();
        }
                
        $subQuery = (new Query())->select('m.id, m.author_name, m.author_uid, m.message_text, m.post_datetime')->from('messages m')->orderBy(['id' => SORT_DESC])->limit(50);
        $query = (new Query())->select(['*'])->from(['a' => $subQuery])->orderBy(['a.id' => SORT_ASC])->all();

        $data = [
            'countAll' => intval($countAll['count']),
            'countPaid' => intval($countPaid['count']),
            'countPublished' => intval($countPublished['count']),
            'messages' => $query,
            'popularCities' => $popularCities,
        ];
        echo json_encode($data);
    }

    public function actionDeletemessage(){
        if(!empty($_POST['id'])){
            $id = $_POST['id'];
            try{
                $result = Yii::$app->db->createCommand()->delete('messages', 'id=:id')->bindValues([':id'=>$id])->execute();
                if(!$result){
                    throw new \Exception('Ошибка удаления сообщения!');
                }else{
                    echo 1;
                }
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }
    }
}
