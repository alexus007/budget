<?php
use yii\widgets\Pjax;
/** @var \app\models\Budget $budgetModel */
/** @var \app\models\BudgetHistory $modelHistory */
\yii\bootstrap\Modal::begin([
    'header' => '<h3>Доход</h3>',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-success btn-block',
        'label' => '<i class="fa fa-plus-circle"></i> ' . Yii::t('app', 'New income'),
    ]
]);

echo $this->render('_income_form',[
    'model' => $modelHistory,
    'budgetModel' => $budgetModel
]);

\yii\bootstrap\Modal::end();