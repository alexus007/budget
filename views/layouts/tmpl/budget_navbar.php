<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        // budget
        [
            'label' => Yii::t('menu','Budget'),
            'url' => ['/'],
            'linkOptions' => ['data-method' => 'get']
        ],
        [
            'label' => Yii::t('menu','BudgetItems'),
            'url' => ['/budget/budget-item/index'],
            'linkOptions' => ['data-method' => 'get']
        ],
        [
            'label' => Yii::t('menu','Report'),
            'url' => ['/budget/report/index'],
            'linkOptions' => ['data-method' => 'get']
        ],
        [
            'label' => Yii::t('menu','Logout') . ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/user/default/logout'],
            'linkOptions' => ['data-method' => 'post']
        ],

    ],
]);
NavBar::end();