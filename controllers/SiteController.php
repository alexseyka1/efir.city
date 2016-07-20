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

class SiteController extends Controller
{
    public $settings = [];
    public $country;
    public $region;
    public $city;
    public $category;
    public $categoryInfo;
    public $seoPage;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'access' => [
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
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    private function construct() {
        $Category = new Category();
        $siteSettings = $Category->getSiteSettings();
        foreach ($siteSettings as $setting){
            $this->settings[$setting['settings_key']] = $setting['value'];
        }
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main2';
        $this->construct();
        if(!empty($_COOKIE['countryId']) && !empty($_COOKIE['regionId']) && !empty($_COOKIE['cityId'])){
            if( !headers_sent() ){
                header("Location: /".$_COOKIE['cityId']."/1");
            }else{
                ?>
                <script type="text/javascript">
                    document.location.href="/<?=$_COOKIE['cityId'];?>"."/1";
                </script>
                Redirecting to <a href="/<?=$_COOKIE['cityId'];?>/1">/<?=$_COOKIE['cityId'];?>/1</a>
                <?php
            }
            die();
        }else {
            $Category = new Category();
            $allCountries = $Category->getCountry();
            $data = [
                'allCountries' => $allCountries,
            ];
            return $this->render('index', $data);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->construct();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $this->construct();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $this->construct();
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Экшн для выбора города
     * @param $cityId
     * @return string
     */
    public function actionCity($cityId) {
        $this->layout = 'main2';
        $this->construct();
        if(preg_match_all('/^\d+$/',$cityId)){
            if( !headers_sent() ){
                header("Location: /".$cityId."/1");
            }else{
                ?>
                <script type="text/javascript">
                    document.location.href="/<?=$cityId;?>"."/1";
                </script>
                Redirecting to <a href="/<?=$cityId;?>/1">/<?=$cityId;?>/1</a>
                <?php
            }
            die();
        }else{
            return $this->render('error',[
                'name' => 'Ошибка 404!',
                'message' => 'Неверно указан id города!',   
            ]);
        }
    }

    public function actionCategory($cityId, $categoryId) {
        $this->layout = 'main2';
        $this->construct();
        if(preg_match_all('/^\d+$/',$cityId)
         && preg_match_all('/^\d+$/',$categoryId)) {
            $Category = new Category();
            $allCategories = $Category->getCategoryByCity($cityId);
            $cityInfo = $Category->getInfoFromCity($cityId);
            $seoPage = $Category->getSeoPage($_SERVER['REQUEST_URI']);
            $categoryInfo = $Category->getCategoryInfo($cityId, $categoryId);
            $this->city = $cityInfo['city_name'];
            $this->region = $cityInfo['region_name'];
            $this->country = $cityInfo['country_name'];
            $this->seoPage = $seoPage;
            $this->categoryInfo = $categoryInfo;
            $data = [
                'cityId' => $cityId,
                'categoryId' => $categoryId,
                'allCategories' => $allCategories,
                'cityInfo' => $cityInfo,
                'seoPage' => $seoPage,
                'categoryInfo' => $categoryInfo,
            ];
            $this->layout = 'cityt';
            return $this->render('category', $data);
        }else{
            return $this->render('error',[
                'name' => 'Ошибка 404!',
                'message' => 'Неверно указан id категории!'
            ]);
        }
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->construct();
        return $this->render('about');
    }

    public function actionRemovecookies() {
        setcookie('cityId','');
        setcookie('countryId','');
        setcookie('regionId','');
        if( !headers_sent() ){
            header("Location: /");
        }else{
            ?>
            <script type="text/javascript">
                document.location.href="/";
            </script>
            Redirecting to <a href="/">/</a>
            <?php
        }
        die();
    }
}
