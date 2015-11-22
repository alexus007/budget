<?php
/** @var \app\models\Budget $budgetModel */
/** @var \app\models\BudgetHistory $modelHistory */
\yii\bootstrap\Modal::begin([
    'header' => '<h3>Расход</h3>',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-danger btn-block',
        'label' => '<i class="fa fa-minus-circle"></i> ' . Yii::t('app', 'New costs'),
    ]
]);

echo $this->render('_costs_form',[
    'model' => $modelHistory,
    'budgetModel' => $budgetModel
]);

\yii\bootstrap\Modal::end();
?>