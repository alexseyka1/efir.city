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
        if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId) && preg_match_all('/^\d+$/',$lastMessageId)){ 
            $Category = new Category();
            $newMessages = $Category->getNewMessages($cityId, $categoryId, $lastMessageId);
            echo json_encode($newMessages);
        }
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
            $Category = new Category();
            if(!empty($_POST['data'])){
                echo $Category->addNewMessage($cityId, $categoryId, $_POST['data']);
            }
        }
    }

}