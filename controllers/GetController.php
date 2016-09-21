<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;

class GetController extends Controller {

    public function actionRegions() {
        // Yii::$app->request->isAjax и Yii::$app->request->isPost
        if(Yii::$app->request->isAjax && !empty($_REQUEST['countryId'])){
            $Category = new Category();
            $allRegions = $Category->getRegion($_REQUEST['countryId']);
            echo json_encode($allRegions);
        }
    }
    public function actionCities() {
        // Yii::$app->request->isAjax и Yii::$app->request->isPost
        if(Yii::$app->request->isAjax && !empty($_REQUEST['regionId'])){
            $Category = new Category();
            $allCities = $Category->getCities($_REQUEST['regionId']);
            echo json_encode($allCities);
        }
    }
    
    public function actionAjaxmessages($cityId, $categoryId, $lastMessageId) {
        header('Content-Type: text/event-stream; charset=utf-8');
        if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId) && preg_match_all('/^\d+$/',$lastMessageId)){
            \Yii::$app->response->format = Response::FORMAT_RAW;
            $headers = Yii::$app->response->headers;
            $headers->set('Content-Type', 'text/event-stream; charset=utf-8');

            $counter = rand(1, 10);

            /*$Category = new Category();
            $newMessages = $Category->getNewMessages($cityId, $categoryId, $lastMessageId);
            echo 'data: ' . json_encode($newMessages) . '\n\n';
            if($newMessages[(count($newMessages)-1)] && $newMessages[(count($newMessages)-1)]['id']){
                $lastMessageId = $newMessages[(count($newMessages)-1)]['id'];
            }*/
            $Category = new Category();
            $id = 1;
            while (1) {
                echo "id: " . $id . "\n";
                echo "event: ping\n";
                $newMessages = $Category->getNewMessages($cityId, $categoryId, $lastMessageId);
                echo 'data: ' . json_encode($newMessages);
                echo "\n\n";
                if($newMessages[(count($newMessages)-1)] && $newMessages[(count($newMessages)-1)]['id']){
                    $lastMessageId = $newMessages[(count($newMessages)-1)]['id'];
                }
                
                $id++;
                ob_end_flush();
                flush();
                sleep(1);
            }
        }

        /*if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId) && preg_match_all('/^\d+$/',$lastMessageId)){
            $Category = new Category();
            $newMessages = $Category->getNewMessages($cityId, $categoryId, $lastMessageId);
            echo json_encode($newMessages);
        }*/
    }
    
    public function actionInfinitescroll($cityId, $categoryId, $firstMessageId) {
        if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId) && preg_match_all('/^\d+$/',$firstMessageId)){
            $Category = new Category();
            $newMessages = $Category->getPrevMessages($cityId, $categoryId, $firstMessageId);
            echo json_encode($newMessages);
        }
    }
    
    public function actionNewmessage($cityId, $categoryId){
        if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId)){
            if(!empty($_POST)){
                $Category = new Category();
                if(!empty($_POST['data'])){
                    echo $Category->addNewMessage($cityId, $categoryId, $_POST['data']);
                }   
            }else{
                header('Location: /');
                echo "<script>window.location = '/';</script>";
            }
        }
    }
    
    public function actionMessageinfo($messageId){
        if(preg_match_all('/^\d+$/',$messageId)){
            $Category = new Category();
            $messageInfo = $Category->getMessageInfo($messageId);
            echo json_encode($messageInfo);
        }else{
            header('Location: /');
        }
    }

}