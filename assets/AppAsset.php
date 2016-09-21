<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use \yiizh\fuelux\FuelUXAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'smiles/jquery.cssemoticons.css',
        'css/style.css',
        /*'css/jquery.custom-scroll.css',
        'css/jquery.custom-scroll2.css',
        'css/jquery.custom-scroll3.css',
        'css/jquery.custom-scroll4.css',
        'css/jquery.custom-scroll5.css', */   
    ];
    public $js = [
        //'js/jquery.custom-scroll.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
        //'yiizh\fuelux\FuelUXAsset',
    ];
}
