<?php
use yii\helpers\Html;

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=!empty($this->context->seoPage) ? $this->context->seoPage['meta'] : '';?>
    <?= Html::csrfMetaTags() ?>
    <title><?=!empty($this->context->seoPage) ? Html::encode($this->context->seoPage['title']) : '';?></title>
    <?php $this->head() ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/style-main.css">
    <link href="/css/jquery.custom-scroll.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.custom-scroll.js"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body class="main-page">
<button class="btn">Войти в эфир</button>
<header class="main-header">
    <div class="logo">
        <a href="/"><img src="/img/logo.png"></a>
    </div>
</header>
<a href="#" class="main1"><img src="/img/main1.png"></a>
<a href="#" class="main2"><img src="/img/main2.png"></a>
<a href="#" class="main3"><img src="/img/main3.png"></a>
<a href="#" class="main4"><img src="/img/main4.png"></a>
<a href="#" class="main5"><img src="/img/main5.png"></a>
<div class="popupbg"></div>
<div class="popup main">
    <div class="close"><img src="/img/close.jpg"></div>
    <div class="content">
        <div class="top">
            Выберите ваш город
        </div>
        <div class="select" id="selectedRegion">Регион<span></span></div>
        <div class="selects">
            <div class="close-btn"></div>
            <div id="selects" class="sss">
                <? if(!empty($this->context->allRegions)){
                    foreach ($this->context->allRegions as $allRegion) {
                        echo "<a class='regionsLinks' data-id='".$allRegion['region_id']."'>".$allRegion['name']."</a>";
                    }
                }?>
            </div>
        </div>
        <div class="select disabled" id="selectedCity">Город<span></span></div>
        <div class="selects second">
            <div class="close-btn"></div>
            <div id="selects2" class="sss">
            </div>
        </div>
        <button disabled="disabled" id="goToChatButton">Выбрать</button>
        <div class="list">
            <?=\app\models\Category::renderAllCities();?>
            <div class="clear"></div>
        </div>
    </div>
</div>
</body>
<script>
    $(function() {
       /* $('#items').customScroll();
        $('#selects').customScroll();
        $('#selects2').customScroll();
        $('#selects3').customScroll();
        $('#selects4').customScroll();*/
        $('.header .menu-button').click(function() {
            $('.menu-bg').fadeIn(1);
            $('.left-side').addClass('opened');
        });
        $('.menu-bg').click(function() {
            $(this).fadeOut(1);
            $('.left-side').removeClass('opened');
        });
        $('.left-side .after').click(function() {
            $('.menu-bg').fadeOut(1);
            $('.left-side').removeClass('opened');
        });
        $('.popup .select').click(function() {
            $('.popup .selects').fadeOut(1);
            $(this).next('.popup .selects').fadeIn(1);
        });
        $('.popup .selects .close-btn').click(function() {
            $('.popup .selects').fadeOut(1);
        });
        $('.header .city-select').click(function() {
            $('.popupbg').fadeIn(1);
            $('.popup.main').fadeIn(1);
        });
        $('.main-page button').click(function() {
            $('.popupbg').fadeIn(1);
            $('.popup.main').fadeIn(1);
        });
        $('.left-side .city-select.first').click(function() {
            $('.menu-bg').fadeOut(1);
            $('.left-side').removeClass('opened');
            $('.popupbg').fadeIn(1);
            $('.popup.regions').fadeIn(1);
        });
        $('.left-side .city-select.second').click(function() {
            $('.menu-bg').fadeOut(1);
            $('.left-side').removeClass('opened');
            $('.popupbg').fadeIn(1);
            $('.popup.cities').fadeIn(1);
        });
        $('.popupbg').click(function() {
            $(this).fadeOut(1);
            $('.popup').fadeOut(1);
        });
        $('.popup .close').click(function() {
            $('.popupbg').fadeOut(1);
            $('.popup').fadeOut(1);
        });
        jQuery('.spoiler-body').hide();
        jQuery('.spoiler-head').click(function(){
            jQuery(this).toggleClass("folded").next().toggle();
        })
    });
</script>
<script src="/js/common.js"></script>
</html>