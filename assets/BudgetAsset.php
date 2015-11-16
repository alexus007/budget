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
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\FontAwesomeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}