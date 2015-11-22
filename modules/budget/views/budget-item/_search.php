<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\query\BudgetItemSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="budget-item-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'patent_id') ?>

		<?= $form->field($model, 'currency_id') ?>

		<?= $form->field($model, 'type_budget_item_id') ?>

		<?= $form->field($model, 'name') ?>

		<?php // echo $form->field($model, 'ammount') ?>

		<?php // echo $form->field($model, 'date') ?>

		<?php // echo $form->field($model, 'active') ?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
