<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\widgets\HelpPopover;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\query\BudgetSearch $searchModel
 */

$this->title = Yii::t('app', 'Budgets');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="giiant-crud budget-index">

    <?php //     echo $this->render('_search', ['model' =>$searchModel]);?>

    <div class="clearfix">
        <p class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'New'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="pull-right">
        </div>
    </div>


    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                <i><?= Yii::t('app', 'Budgets') ?> <?php
                    echo HelpPopover::widget([
                        'dataOptions' => [
                            'content'=>Yii::t('help', 'BudgetHelp'),
                        ]
                    ]);
                    ?></i>
            </h2>
        </div>

        <div class="panel-body">

            <div class="table-responsive">
                <?= GridView::widget([
                    'layout' => '{summary}{pager}{items}{pager}',
                    'dataProvider' => $dataProvider,
                    'pager'        => [
                        'class'          => yii\widgets\LinkPager::className(),
                        'firstPageLabel' => Yii::t('app', 'First'),
                        'lastPageLabel'  => Yii::t('app', 'Last')                ],
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                    'headerRowOptions' => ['class'=>'x'],
                    'columns' => [

                        [
                            'class' => yii\grid\ActionColumn::className(),
                            'contentOptions' => ['nowrap'=>'nowrap']
                        ],

                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'urlCreator' => function($action, $model, $key, $index) {
                                // using the column name as key, not mapping to 'id' like the standard generator
                                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                                return Url::toRoute($params);
                            },
                            'contentOptions' => ['nowrap'=>'nowrap']
                        ],*/
                        /*// generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
                        [
                            'class' => yii\grid\DataColumn::className(),
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                if ($rel = $model->getUser()->one()) {
                                    return Html::a($rel->id, ['user/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                                } else {
                                    return '';
                                }
                            },
                            'format' => 'raw',
                        ],
                        // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
                        [
                            'class' => yii\grid\DataColumn::className(),
                            'attribute' => 'currency_id',
                            'value' => function ($model) {
                                if ($rel = $model->getCurrency()->one()) {
                                    return Html::a($rel->name, ['currency/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                                } else {
                                    return '';
                                }
                            },
                            'format' => 'raw',
                        ],
                        */
                        'title',
                        [
                            'attribute'=>'currency_id',
                            'label'=>Yii::t('app', 'Currency ID'),
                            'format'=>'text',
                            'content'=>function($data){
                                return $data->currency->name;
                            },
                            'filter' => \app\models\Currency::getActiveCurrency(),
                        ],
                        'income_limit',
                        'costs_limit',
                        [
                            'filter' => kartik\date\DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'created_date',
                                'pluginOptions' => ['format' => 'dd.mm.yyyy']
                            ]),
                            'attribute' => 'created_date',
                            'format' => 'date',
                        ],
                    ],
                ]); ?>
            </div>

        </div>

    </div>

    <?php \yii\widgets\Pjax::end() ?>


</div>
