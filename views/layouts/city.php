<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=!empty($this->context->seoPage) ? $this->context->seoPage['meta'] : '';?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/fuelux/css/fuelux.min.css" rel="stylesheet">
</head>
<body class="fuelux ">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    /*NavBar::begin([
        'brandLabel' => 'Efir.cityt',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();*/
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => ['label' => 'Главная',
                'url' => Yii::$app->getHomeUrl()],
        ]) ?>
        <div class="container mainWindow">

            <!--    Шапка - логотип сайта   -->

            <div class="row">
                <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4 logoHeader" onclick="window.location='/'">
                    <?=$this->context->settings['site_name'];?>
                </div>
                <div class="col-md-4">&nbsp;</div>
            </div>

            <div class="row">
                <div class="col-md-12 titleService">
                    <? if(!empty($this->context->seoPage)){ echo $this->context->seoPage['title'];}else{ ?>
                        Общение в <?=$this->context->city;?><small style="color:grey">, <?=$this->context->region;?>, <?=$this->context->country;?></small>
                    <? } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 threeTitleText">
                    <?
                        $title_text = !empty($this->context->seoPage) ? $this->context->seoPage['title_text'] : $this->context->settings['default_title_text'];
                        $title_text = str_replace('{city}',$this->context->city,$title_text);
                        $title_text = str_replace('{category}',$this->context->categoryInfo['category_name'],$title_text);
                    echo $title_text;
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0;">
                            <button class="btn btn-primary btn-block buttonBack" id="buttonBack">
                                <span class="glyphicon glyphicon-chevron-left"></span> Выбрать другой город
                            </button>
                        </div>
                    </div>
                    <div class="row leftBarBlock">
                        <div class="row leftBarBlockHeader"><?=$this->context->settings['html_1_header'];?></div>
                        <div class="row leftBarText"><?=$this->context->settings['html_1_text'];?></div>
                    </div>
                    <div class="row leftBarBlock">
                        <div class="row leftBarBlockHeader"><?=$this->context->settings['html_2_header'];?></div>
                        <div class="row leftBarText"><?=$this->context->settings['html_2_text'];?></div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row centerWindowDiv" id="mainContentWindow">
                        <?= $content ?>
                    </div>
                    <button class="btn btn-block btn-default bottomButtonWrite" id="bottomButtonWrite">
                        НАПИСАТЬ СООБЩЕНИЕ
                    </button>
                </div>
                <div class="col-md-2">
                    <div class="row leftBarBlock rightBarBlock">
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive" id="pageInstruction" data-url="/instructions">Инструкция</div>
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive" id="pageCost" data-url="/cost">Стоимость</div>
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive" id="pageRules" data-url="/rules">Правила сервиса</div>
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive" id="pageFaq" data-url="/faq">Вопросы и ответы</div>
                        <!--<div class="row leftBarBlockHeader rightBarBlockHeaderNonActive">Еще что-нибудь</div>
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive">Еще что-нибудь</div>
                        <div class="row leftBarBlockHeader rightBarBlockHeaderNonActive">И еще что-нибудь</div>-->
                    </div>
                    <div class="row rightBarBlock" style="text-align: center">
                        <h3 style="color:#426ca8">Мы в Соц.сетях</h3>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 socialBlock socialBlockVk" data-url="<?=$this->context->settings['vk'];?>">
                            <div class="socialIcon">&nbsp;</div>
                            <span class="socialBlockTextVk">В</span>
                            <div style="margin: 0px; padding:0px;font-size: 10px;">Вконтакте</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 socialBlock socialBlockFb" data-url="<?=$this->context->settings['facebook'];?>">
                            <div class="socialIcon">&nbsp;</div>
                            <span class="socialBlockTextFb">f</span>
                            <div style="margin: 0px; padding:0px;font-size: 10px;">Facebook</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 socialBlock socialBlockOk" data-url="<?=$this->context->settings['ok'];?>">
                            <div class="socialIcon">&nbsp;</div>
                            <span class="socialBlockTextOk">Ok</span>
                            <div style="margin: 0px; padding:0px;font-size: 10px;">Ок</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<footer class="footer" style="padding-bottom: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <p class="pull-left">
                    <?=!empty($this->context->settings['layout_footer']) ? $this->context->settings['layout_footer'] : 'Efir.city';?>
                </p>
            </div>
            <div class="col-md-3">
                <p class="pull-left">&copy; <a href="http://vk.com/alexseyka1" target="_blank">alexseyka1</a> <?= date('Y') ?></p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>

<script src="/fuelux/js/fuelux.min.js"></script>
<script src="/js/scrollto.js"></script>
<script src="/js/jquery.sticky.js"></script>
<script src="/js/jquery.inputmask.bundle.js"></script>
<script src="/js/jquery.noty.packaged.min.js"></script>


</html>
<?php $this->endPage() ?>
