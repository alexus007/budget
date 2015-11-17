<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 16.11.15
 * Time: 11:47
 */

namespace app\assets;


use yii\web\AssetBundle;

class BudgetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        YII_ENV_DEV ? 'css/site.css' : 'css/site.min.css'
    ];
    public $js = [
        YII_ENV_DEV ? 'js/dist/build.js' : 'js/dist/build.min.js'
    ];
    public $depends = [
        'app\assets\FontAwesomeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}