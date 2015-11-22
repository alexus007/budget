<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/**
 * @var yii\web\View $this
 * @var app\models\Report$model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="panel panel-default">

    <div class="panel-body">

        <div class="budget-item-form">

            <?php $form = ActiveForm::begin([
                    'id' => 'Report',
                    'layout' => 'horizontal',
                    'enableClientValidation' => true,
                    'errorSummaryCssClass' => 'error-summary alert alert-error'
                ]
            );
            ?>

            <div class="">
                <?php $this->beginBlock('main'); ?>


                <p></p>
                <?=
                $form->field($model, 'budget_id')->dropDownList(
                    ArrayHelper::map(\app\models\Budget::baseQuery()->all(),'id', 'title'),
                    ['prompt' => Yii::t('app', 'Select')]
                ); ?>
                <?=
                $form->field($model, 'currency_id')->dropDownList(
                    app\models\Currency::getActiveCurrency(),
                    ['prompt' => Yii::t('app', 'Select')]
                ); ?>
                <?=
                $form->field($model, 'type_id')->dropDownList(
                    ArrayHelper::merge([0=>'Все операции'],
                    ArrayHelper::map(app\models\TypeBudgetItem::find()->all(), 'id', 'type')),
                    ['prompt' => Yii::t('app', 'Select')]
                ); ?>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="budgetitem-date">Период</label>
                    <div class="col-sm-6">
                        <?=DatePicker::widget([
                            'model' => $model,
                            'name' => 'Report[date_from]',
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'Report[date_to]',
                            'separator' => '-',
                            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'class' => 'col-sm-6'],
                        ])?>
                    </div>
                </div>


                <?php $this->endBlock(); ?>

                <?=
                Tabs::widget(
                    [
                        'encodeLabels' => false,
                        'items' => [ [
                            'label'   => '',
                            'content' => $this->blocks['main'],
                            'active'  => true,
                        ], ]
                    ]
                );
                ?>
                <hr/>
                <?php echo $form->errorSummary($model); ?>
                <?= Html::submitButton(
                    '<span class="glyphicon glyphicon-check"></span> ' . Yii::t('app', 'View report'),
                    [
                        'id' => 'save-' . $model->formName(),
                        'class' => 'btn btn-success'
                    ]
                );
                ?>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>

</div>
