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
    <link rel="stylesheet" href="/fuelux/css/fuelux.css">
    <link rel="stylesheet" href="/css/style.css">

    <? if(!empty($this->context->categoryId) && in_array($this->context->categoryId, [2,3,4,5])) { ?>
        <link rel="stylesheet" href="/css/jquery.custom-scroll<?=$this->context->categoryId;?>.css">
    <? }else{ ?>
        <link rel="stylesheet" href="/css/jquery.custom-scroll.css">
    <? } ?>
</head>
<body>
<div id="loaderDiv" style="
    display: flex !important;
    opacity: 1 !important;
    position: fixed !important;
    background: rgba(0, 0, 0, 0.85);
    width: 100vw !important;
    height: 100vh !important;
    z-index: 999999 !important;
    align-content: center !important;
    vertical-align: middle !important;">

    <div style="
    display: block !important;
    margin-top: auto !important;
    margin-bottom: auto !important;
    //margin-left: calc(35vw);
    width:100% !important;
    text-align: center !important;
    color: white;
    font-size: 2rem !important;
    font-weight: 100 !important;
">Загрузка...</div>
</div>
<?php $this->beginBody() ?>

<div class="menu-bg"></div>
<header class="header">
    <div class="menu-button"></div>
    <div class="logo">
        <a href="/">
            <img src="/img/logo1.jpg">
            <span>Городской эфир</span>
            <?=!empty($this->context->city) ? $this->context->city : '';?>
        </a>
    </div>
    <div class="city-select">
        <?=!empty($this->context->city) ? $this->context->city : 'Выбрать город';?>
        <span></span>
    </div>
    <div class="weather">
        <!--<img src="/img/weather.jpg"> +18-->
        <?php
            if(!empty($this->context->weather)){
                $image = str_replace('22x22', '48x48', $this->context->weather['image']);
                echo '<img src="'.$image.'">'.$this->context->weather['temp'];
            }
        ?>
    </div>
    <div class="clear"></div>
</header>
<div class="main-content">
    <?php
        if(!empty($this->context->categoryId)){
            if($this->context->categoryId == 1){
                echo '<div class="board news">';
            }elseif($this->context->categoryId == 3){
                echo '<div class="board actions">';
            }elseif($this->context->categoryId == 4){
                echo '<div class="board relax">';
            }elseif($this->context->categoryId == 5){
                echo '<div class="board contact">';
            }else{
                echo '<div class="board">';
            }   
        }else{
            echo '<div class="board">';
        }
    ?>
        <?=$content;?>
    </div>
    <aside class="right-side">
        <div class="top-text">
<!--            <p>Это текстовое сообщение имеет 300 символов с пробелами. Это текстовое сообщение имеет 300 символов с пробелами. Это текстовое сообщение имеет 300 символов с пробелами. Это текстовое сообщение имеет 300 символов с пробелами. Это текстовое сообщение имеет 300 символов с пробелами. Даже чуточку больше.</p>-->
            <? if(!empty($this->context->seoPage)){;?><?=!empty($this->context->seoPage['html_1_header']) ? $this->context->seoPage['html_1_header'] : $this->context->settings['html_1_header'];?>
            <?=!empty($this->context->seoPage['html_1_text']) ? $this->context->seoPage['html_1_text'] : $this->context->settings['html_1_text'];?>
            <? } ?>
        </div>
        <div class="banner">

        </div>
    </aside>
    <div class="clear"></div>
</div>
<div class="left-side">
    <div class="after"></div>
    <img src="/img/image.jpg" class="image">
    <div class="city-select"><?=!empty($this->context->city) ? $this->context->city : 'Выбрать город';?> <span></span></div>
    <nav class="left-menu">
        <ul>
            <li><img src="/img/icon1.png"><a href="/akcii">Акции и конкурсы</a></li>
            <li><img src="/img/icon2.png"><a href="/cost">Стоимость</a></li>
            <li><img src="/img/icon3.png"><a href="/instructions">Инструкция</a></li>
            <li><img src="/img/icon4.png"><a href="/rules">Правила сервиса</a></li>
            <li><img src="/img/icon5.png"><a href="/faq">Вопросы и ответы</a></li>
        </ul>
    </nav>
    <div class="social">
        <span>Мы в соц.сетях</span>
        <div class="images">
            <a href="#"><img src="/img/vk.png"></a>
            <a href="#"><img src="/img/fb.png"></a>
            <a href="#"><img src="/img/ok.png"></a>
        </div>
    </div>
</div>
<div class="popupbg"></div>
<div class="popup">
    <div class="close"><img src="/img/close.jpg"></div>
    <div class="content">
        <div class="top">
            Выберите ваш город
        </div>
        <div class="select" id="selectedRegion">Регион<span></span></div>
        <div class="selects">
            <div class="close-btn"></div>
            <!--<input type="text"><input type="submit">-->
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
            <!--<input type="text"><input type="submit">-->
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

<?php $this->endBody() ?>
</body>

<script src="/js/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.js"></script>
<script src="/fuelux/js/fuelux.js"></script>
<script src="/js/jquery.custom-scroll.js"></script>
<script src="/js/jquery.inputmask.bundle.js"></script>
<script src="/js/jquery.noty.packaged.min.js"></script>
<script src="/js/scrollto.js"></script>
<script src="/smiles/jquery.cssemoticons.min.js"></script>
<script src="/js/common.js"></script>
<script>
    $(function(){
        $(document).ready(function(){
            setTimeout(function() {
                $('div#loaderDiv').animate({opacity: 'toggle'}, 500, function(){
                    $('div#loaderDiv').remove();
                });
            }, 2000);
        });
    });
</script>
<!--<script src="/semantic/semantic.min.js"></script>-->


</html>
<?php $this->endPage() ?>
