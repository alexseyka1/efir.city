<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
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
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/semantic/semantic.css">
    <link rel="stylesheet" href="/css/new.css">
</head>
<body>
<?php $this->beginBody() ?>

<div class="ui sidebar vertical inverted menu">
    <a class="item" href="/user/security/logout">
        <h4 class="ui grey header"><img class="ui avatar image" src="http://semantic-ui.com/images/avatar/large/elliot.jpg"><?=\Yii::$app->user->identity->username;?></h4>
        <p>Выйти из админки</p>
    </a>
    <a href="/admin" class="item">
        <i class="home icon"></i> Главная
    </a>

    <div class="item">
        <div class="header">Редактирование</div>
        <div class="menu">
            <a href="/admin/country" class="item">
                <i class="world icon"></i> Редактирование стран
            </a>
            <a href="/admin/region" class="item">
                <i class="world icon"></i> Редактирование регионов
            </a>
            <a href="/admin/city" class="item">
                <i class="world icon"></i> Редактирование городов
            </a>
        </div>
    </div>

    <div class="item">
        <div class="header">Категории</div>
        <div class="menu">
            <a href="/admin/category" class="item">
                <i class="list layout icon"></i> Редактирование категорий
            </a>
            <a href="/admin/categorydefault" class="item">
                <i class="list layout icon"></i> Базовые категории
            </a>
        </div>
    </div>

    <a href="/admin/seo" class="item">
        <i class="line chart icon"></i> SEO
    </a>
    <a href="/admin/statics" class="item">
        <i class="file outline icon"></i> Статические страницы
    </a>

    <div class="item">
        <div class="header">Сообщения</div>
        <div class="menu">
            <a href="/admin/messages" class="item"><i class="mail outline icon"></i> Сообщения</a>
            <a href="/admin/statmessages" class="item"><i class="mail outline icon"></i> Статистика сообщений</a>
        </div>
    </div>

    <a href="/admin/sitesettings" class="item">
        <i class="setting icon"></i> Настройки сайта
    </a>
</div>
<div class="ui internally celled grid" style="max-height: 85px;">
    <div class="row topMenu">
        <div class="two wide column leftBar">
            <img src="http://symboldrama.ru/image/news/all/Peterburg.jpg" class="cityImage">
        </div>
        <div class="eight wide column">
            
        </div>
        <div class="six wide column" style="padding-top: 24px; box-shadow: none;">
            <span style="float:left;">
                <img src="/css/cloudy-night.svg" style="text-align: right;">+18
            </span>
            <span style="float:right;">
                <div class="ui selection dropdown" style="border-radius: 0px; border-color: #cecece">
                  <input type="hidden" name="gender" value="1">
                  <i class="dropdown icon"></i>
                  <div class="default text">Gender</div>
                  <div class="menu">
                    <div class="item active selected" data-value="1" selected>Санкт-Петербург</div>
                    <div class="item" data-value="2">Москва</div>
                  </div>
                </div>
            </span>
        </div>
    </div>
</div>
<div class="ui internally celled grid mainWindow">
    <div class="row">
        <div class="two wide column leftBar leftBarMenu">
            <div class="ui segments">
                <div class="ui vertical segment">
                    <p>1</p>
                </div>
                <div class="ui vertical segment">
                    <p>2</p>
                </div>
                <div class="ui vertical segment">
                    <p>3</p>
                </div>
            </div>
        </div>
        <div class="eight wide column">
            5
        </div>
        <div class="six wide column">
            6
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
<script src="/js/jquery.min.js"></script>
<script src="/semantic/semantic.min.js"></script>
<script src="/js/scrollto.js"></script>
<script src="/js/jquery.sticky.js"></script>
<script src="/js/jquery.inputmask.bundle.js"></script>
<script src="/js/jquery.noty.packaged.min.js"></script>
<script>
    $(document).ready(function(){
        $("a.sidebar-toggle").click(function() {
            $('.ui.sidebar').sidebar('toggle');
        });
        $('.ui.dropdown')
            .dropdown()
        ;
    });
</script>

</html>
<?php $this->endPage() ?>
