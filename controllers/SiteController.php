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
    public $categoryId;
    public $allRegions;
    public $weather;
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
        $allRegions = $Category->getRegion(1);
        $this->allRegions = $allRegions;
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
                echo "<script>window.location = /".$_COOKIE['cityId']."/</script>";
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
            $seoPage = $Category->getSeoPage('/');
            $allCountries = $Category->getCountry();
            $allRegions = $Category->getRegion(1);
            $this->allRegions = $allRegions;
            $this->seoPage = $seoPage;
            $data = [
                'allCountries' => $allCountries,
            ];
            return $this->renderPartial('index', $data);
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

    /**
     * Экшн для выбора города по ЧПУ
     * @param $city
     * @return string
     */
    public function actionRucity($city) {
        if($city === "removeAllCookies"){
            $this->actionRemovecookies();
            exit;
        }
        try {
                $city = trim($city);
            if (!empty($city) && preg_match('/^[A-Za-zА-Яа-яЁё]+$/u', $city)) {
                $this->layout = 'main2';
                $this->construct();
                $Category = new Category();
                $city = $Category->getCityFromSeo($city);
                if(!preg_match('/^\d+$/',$city)){
                    echo $city;
                }else{
                    $this->actionCity($city);
                }
            }elseif(!preg_match('/^[A-Za-zА-Яа-яЁё]+$/u', $city)) {
                return $this->render('error',[
                    'name' => 'Ошибка 404!',
                    'message' => 'Неверно указано название города!',
                ]);
            }else {
                throw new \Exception('Страница не найдена!');
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Экшн для переписки в выбранной категории
     */
    public function actionCategory($cityId, $categoryId, $messageId = null) {
        if(!empty($messageId) && preg_match_all('/^\d+$/',$messageId)){
            echo "<input type='hidden' role='var' id='answerMessageId' value='{$messageId}'>";
        }
        $this->layout = 'main2';
        $this->construct();
        if(preg_match_all('/^\d+$/',$cityId)
         && preg_match_all('/^\d+$/',$categoryId)) {
            $Category = new Category();
            echo "<input type='hidden' role='var' id='cityId' value='{$cityId}'>";
            echo "<input type='hidden' role='var' id='categoryId' value='{$categoryId}'>";
            $allCategories = $Category->getCategoryByCity($cityId);
            $cityInfo = $Category->getInfoFromCity($cityId);
            if(!empty($cityInfo['weather'])){
                $xml = simplexml_load_file('https://export.yandex.ru/bar/reginfo.xml?region='.$cityInfo['weather'].'.xml');
                if(!empty($xml->weather)){
                    if(!empty($xml->weather->day->day_part)){
                        $weather = [
                            'image' => $xml->weather->day->day_part->{'image-v2'},
                            'temp' => $xml->weather->day->day_part->temperature[0]
                        ];
                    }
                }
            }
            $seoPage = $Category->getSeoPage($_SERVER['REQUEST_URI']);
            $categoryInfo = $Category->getCategoryInfo($cityId, $categoryId);
            $allRegions = $Category->getRegion(1);
            $this->allRegions = $allRegions;
            $this->city = $cityInfo['city_name'];
            $this->region = $cityInfo['region_name'];
            $this->country = $cityInfo['country_name'];
            $this->seoPage = $seoPage;
            $this->categoryId = $categoryId;
            $this->categoryInfo = $categoryInfo;
            $this->weather = !empty($weather) ? $weather : null;
            $data = [
                'cityId' => $cityId,
                'categoryId' => $categoryId,
                'allCategories' => $allCategories,
                'cityInfo' => $cityInfo,
                'seoPage' => $seoPage,
                'categoryInfo' => $categoryInfo,
            ];
            $this->layout = 'city';
            return $this->render('category', $data);
        }else{
            return $this->render('error',[
                'name' => 'Ошибка 404!',
                'message' => 'Неверно указан id категории!'
            ]);
        }
    }

    /**
     * Экшн ЧПУ
     */
    public function actionRucategory($city, $category, $messageId = null) {
        if(!empty($messageId) && preg_match_all('/^\d+$/',$messageId)){
            echo "<input type='hidden' role='var' id='answerMessageId' value='{$messageId}'>";
        }
        try{
            $city = trim($city);
            $category = trim($category);
            if (!empty($city) && preg_match('/^[A-Za-zА-Яа-яЁё_-]+$/u', $city) 
             && !empty($category) && preg_match('/^[A-Za-zА-Яа-яЁё_-]+$/u', $category))
            {
                $this->layout = 'main2';
                $this->construct();
                $Category = new Category();
                $url = $city . "/" . $category;
                $enUrl = $Category->getUrlBySeo($url);
                if($enUrl !== "Не удалось найти url по ЧПУ"){
                    $expUrl = explode('/', $enUrl);
                    $cityId = $expUrl[1];
                    $categoryId = $expUrl[2];
                    echo "<input type='hidden' role='var' id='cityId' value='{$cityId}'>";
                    echo "<input type='hidden' role='var' id='categoryId' value='{$categoryId}'>";
                    
                    
                    $allCategories = $Category->getCategoryByCity($cityId);
                    $cityInfo = $Category->getInfoFromCity($cityId);
                    if(!empty($cityInfo['weather'])){
                        $xml = simplexml_load_file('https://export.yandex.ru/bar/reginfo.xml?region='.$cityInfo['weather'].'.xml');
                        if(!empty($xml->weather)){
                            if(!empty($xml->weather->day->day_part)){
                                $weather = [
                                    'image' => $xml->weather->day->day_part->{'image-v2'},
                                    'temp' => $xml->weather->day->day_part->temperature[0]
                                ];
                            }
                        }
                    }
                    $seoPage = $Category->getSeoPage($_SERVER['REQUEST_URI']);
                    $categoryInfo = $Category->getCategoryInfo($cityId, $categoryId);
                    $allRegions = $Category->getRegion(1);
                    $this->allRegions = $allRegions;
                    $this->city = $cityInfo['city_name'];
                    $this->region = $cityInfo['region_name'];
                    $this->country = $cityInfo['country_name'];
                    $this->seoPage = $seoPage;
                    $this->categoryId = $categoryId;
                    $this->categoryInfo = $categoryInfo;
                    $this->weather = !empty($weather) ? $weather : null;
                    $data = [
                        'cityId' => $cityId,
                        'categoryId' => $categoryId,
                        'allCategories' => $allCategories,
                        'cityInfo' => $cityInfo,
                        'seoPage' => $seoPage,
                        'categoryInfo' => $categoryInfo,
                    ];
                    $this->layout = 'city';
                    return $this->render('category', $data);
                }else{
                    ?>
                    <script type="text/javascript">
                        document.location.href="/";
                    </script>
                    Redirecting to <a href="/">/</a>
                    <?php
                }
            }
        }catch (\Exception $e){
            echo $e->getMessage();
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
    
    public function actionNewdesign(){
        $this->layout = "new";
        return $this->render('new');
    }
}
