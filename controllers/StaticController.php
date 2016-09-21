<?php

namespace app\controllers;


use app\models\Category;
use app\models\StaticModel;
use Yii;
use yii\web\Controller;

class StaticController extends Controller
{
    public $settings = [];
    public $allRegions;

    /**
     * StaticController constructor.
     */
    public function constructor()
    {
        $Category = new Category();
        $allRegions = $Category->getRegion(1);
        $this->allRegions = $allRegions;
        $siteSettings = $Category->getSiteSettings();
        foreach ($siteSettings as $setting){
            $this->settings[$setting['settings_key']] = $setting['value'];
        }
    }


    public function actionAkcii() {
        $this->layout = 'city';
        $this->constructor();
        $StaticModel = new StaticModel();
        $pageContent = $StaticModel->getStaticPage('akcii');
        $data = [
            'content' => $pageContent,
        ];
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('akcii', $data);
        }else{
            return $this->render('akcii', $data);
        }
    }
    
    public function actionInstructions() {
        $this->layout = 'city';
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
        $this->layout = 'city';
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
        $this->layout = 'city';
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
        $this->layout = 'city';
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