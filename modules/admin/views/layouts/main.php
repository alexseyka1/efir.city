<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$url = explode("/", $_SERVER['REQUEST_URI']);
?>
<html>
    <head>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <style type="text/css">
            html, body {
                font-family: Arial;
            }
            ul.nav li a span {
                color: #348ccb;
            }
            div.leftBar {
                padding: 0;
                //width: 12%;
                border-right: 1px solid rgba(52, 140, 203, 0.4);
                background: #f8f8f8;
                height: 100%;
                z-index: 3;
            }
            div.mainWindow {
                //width: 88%;
                //margin-left: 12%;
                height: 100%;
            }
            div.mainMenu {
                display: flex;
                justify-content: center;
            }
            a.toggle-vis {
                cursor: pointer;
            }
            
            span.toggleLeftBar {
                float: left;
                font-size: 2em;
                padding: 0.35em;
                margin-left: 0;
                left: 0;
                /*box-shadow: 0 0 10px #757575 inset;*/
                color: #757575;
            }
            span.toggleLeftBar:hover {
                color: black;
                cursor: pointer;
            }
            span.toggleLeftBar:active {
                color: #348ccb;
            }
            .ulMenu {
                width: 100%;
                margin: 0;
                padding:0;
            }
            .leftBar .list-group-item:first-child, .leftBar  .list-group-item:last-child, .leftBar  .list-group-item {
                border-radius: 0px;
                padding: 10px;
                margin: 0;
                border: none;
                border-bottom: 1px solid rgba(52, 140, 203, 0.4) !important;
            }
            hr {
                background: #607d8b;
                margin-top: 15px;
                margin-bottom: 15px;
                border: 0;
                border-top: 4px dashed #fff;
            }
        </style>
    </head>
    <body class="fuelux">
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Отмена</button>
                <button type="button" class="btn btn-primary" id="apply">Сохранить</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <div class="container-fluid">
          <div class="row" id="bodyContent">
                <div class="col-sm-2 col-md-2 col-lg-2 leftBar">
                    <div class="list-group">
                        <a href="/admin" class="list-group-item">
                            <span class="glyphicon glyphicon-home"></span> Главная
                        </a>
                        <a href="/admin/country" class="list-group-item">
                            <span class="glyphicon glyphicon-map-marker"></span> Редактирование стран
                        </a>
                        <a href="/admin/region" class="list-group-item">
                            <span class="glyphicon glyphicon-map-marker"></span> Редактирование регионов
                        </a>
                        <a href="/admin/city" class="list-group-item">
                            <span class="glyphicon glyphicon-map-marker"></span> Редактирование городов
                        </a>
                        <hr>
                        <a href="/admin/category" class="list-group-item" style="border-top: 1px solid rgba(52, 140, 203, 0.4) !important;">
                           <span class="glyphicon glyphicon-list"></span> Редактирование категорий
                        </a>
                        <a href="/admin/categorydefault" class="list-group-item">
                            <span class="glyphicon glyphicon-align-justify"></span> Базовые категории 
                        </a>
                        <hr>
                        <a href="/admin/seo" class="list-group-item" style="border-top: 1px solid rgba(52, 140, 203, 0.4) !important;">
                            <span class="glyphicon glyphicon-tag"></span> SEO
                        </a>
                        <a href="/admin/statics" class="list-group-item">
                            <span class="glyphicon glyphicon-file"></span> Статические страницы
                        </a>
                        <hr>
                        <a href="/admin/messages" class="list-group-item" style="border-top: 1px solid rgba(52, 140, 203, 0.4) !important;">
                            <span class="glyphicon glyphicon-envelope"></span> Сообщения
                        </a>
                        <a href="/admin/sitesettings" class="list-group-item">
                            <span class="glyphicon glyphicon-cog"></span> Настройки сайта
                        </a>
                    </div>
                </div>
                <div class="col-sm-10 col-md-10 col-lg-10 mainWindow" style="overflow: auto;">
                    <?=$content;?>
                </div>
          </div>
    </div>

    </body>
    <footer>
        <script src="/js/jquery.min.js"></script>
	    <script src="/bootstrap/js/bootstrap.min.js"></script>
    </footer>
</html>

<script>
    $(document).ready(function(){
        $('.leftBar .list-group .list-group-item').each(function(i, elem){
            if($(elem).attr('href') == window.location.pathname.replace('efir.city','')){
                $(elem).addClass('active');
            }
        });
    });
</script>