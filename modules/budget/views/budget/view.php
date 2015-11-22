<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var app\models\Budget $model
 * @var app\models\BudgetHistory $modelHistory
 * @var yii\data\ActiveDataProvider $providerIncome
 * @var yii\data\ActiveDataProvider $providerCost
 */

$this->title = 'Budget ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Budgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'View');
?>
<div class="giiant-crud budget-view">

    <!-- menu buttons -->
    <p class='pull-left'>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Edit'), ['update', 'id' => $model->id],['class' => 'btn btn-info btn-xs']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'New'), ['create'], ['class' => 'btn btn-success btn-xs']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger btn-xs',
                'style' => 'nowrap',
                'data-confirm' => '' . Yii::t('app', 'Are you sure to delete this item?') . '',
                'data-method' => 'post',
            ]); ?>
    </p>
    <p class="pull-right">
        <?= Html::a('<span class="glyphicon glyphicon-list"></span> ' . Yii::t('app', 'List Budgets'), ['index'], ['class'=>'btn btn-default btn-xs']) ?>
    </p>

    <div class="clearfix"></div>

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <h3><?= $model->title ?> создан: <?=Yii::$app->formatter->asDate($model->created_date);?></h3>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <table class="table table-bordered table-hover">
                    <tbody>
                    <tr>
                        <td>Oжидаемый уровень доходов: <span class="label label-success"><?=$model->income_limit?></span></td>
                        <td>Oбщий ежемесячный лимит расходов: <span class="label label-danger"><?=$model->costs_limit?></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Ввод операций</h4>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <!--         income        -->

                    <?php
                    echo ListView::widget([
                        'dataProvider' => $providerIncome,
                        'itemView' => 'tmpl/_income',
                    ]);
                    ?>

                    <hr>
                    <?php
                    echo $this->render('tmpl/_total_income',[
                        'budgetModel'=>$model,
                        'type' => \app\models\BudgetItem::TYPE_INCOME,
                    ]);
                    ?>
                    <?=$this->render('tmpl/modal_income', ['budgetModel'=>$model, 'modelHistory'=> $modelHistory]);?>

                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <!--          costs      -->

                    <?php
                    echo ListView::widget([
                        'dataProvider' => $providerCost,
                        'itemView' => 'tmpl/_cost',
                    ]);
                    ?>

                    <hr>
                    <?php
                        echo $this->render('tmpl/_total_costs',[
                            'budgetModel'=>$model,
                            'type'=>\app\models\BudgetItem::TYPE_COST,
                        ]);
                    ?>
                    <?=$this->render('tmpl/modal_costs', ['budgetModel'=>$model, 'modelHistory'=> $modelHistory]);?>
                </div>
            </div>
        </div>
    </div>
</div>
