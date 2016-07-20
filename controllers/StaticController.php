<?php

namespace app\controllers;


use app\models\Category;
use app\models\StaticModel;
use Yii;
use yii\web\Controller;

class StaticController extends Controller
{
    public $settings = [];

    /**
     * StaticController constructor.
     */
    public function constructor()
    {
        $Category = new Category();
        $siteSettings = $Category->getSiteSettings();
        foreach ($siteSettings as $setting){
            $this->settings[$setting['settings_key']] = $setting['value'];
        }
    }


    public function actionInstructions() {
        $this->layout = 'main2';
        $this->constructor();
        $StaticModel = new StaticModel();
        $pageContent = $StaticModel->getStaticPage('instructions');
        $data = [
            'content' => $pageContent,
        ];
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('instructions', $data);
        }else{
            return $this->render('instructions', $data);
        }
    }

    public function actionCost() {
        $this->layout = 'main2';
        $this->constructor();
        $StaticModel = new StaticModel();
        $pageContent = $StaticModel->getStaticPage('cost');
        $data = [
            'content' => $pageContent,
        ];
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('cost', $data);
        }else{
            return $this->render('cost', $data);
        }
    }

    public function actionRules() {
        $this->layout = 'main2';
        $this->constructor();
        $StaticModel = new StaticModel();
        $pageContent = $StaticModel->getStaticPage('rules');
        $data = [
            'content' => $pageContent,
        ];
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('rules', $data);
        }else{
            return $this->render('rules', $data);
        }
    }

    public function actionFaq() {
        $this->layout = 'main2';
        $this->constructor();
        $StaticModel = new StaticModel();
        $pageContent = $StaticModel->getStaticPage('faq');
        $data = [
            'content' => $pageContent,
        ];
        if(Yii::$app->request->isAjax){
           return  $this->renderPartial('faq', $data);
        }else{
            return $this->render('faq', $data);
        }
    }



}