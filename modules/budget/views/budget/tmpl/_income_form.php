<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;

/**
 * @var app\models\Budget $budgetModel
 * @var yii\web\View $this
 * @var app\models\BudgetHistory $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="panel panel-default">

    <div class="panel-body">

        <div class="budget-history-form">

            <?php $form = ActiveForm::begin([
                    'id' => 'BudgetHistoryIncome',
                    'layout' => 'horizontal',
                    'enableClientValidation' => true,
                    'errorSummaryCssClass' => 'error-summary alert alert-error'
                ]
            );
            ?>

            <div class="">
                <?php $this->beginBlock('main'); ?>

                <p>
                    <?php
                    // hidden field
                    echo Html::activeHiddenInput($model, 'budget_id',['value'=>$budgetModel->id]);
                    ?>
                <div class="form-group">
                    <?php
                    echo Html::activeLabel($model, 'ammount', ['class'=>'control-label col-sm-3']);
                    ?>
                    <div class="col-xs-3">
                        <?php echo Html::activeInput('text', $model, 'ammount', ['class'=>'form-control'])?>
                    </div>
                    <div class="col-xs-3">
                        <?php
                        echo Html::activeDropDownList($model, 'currency_id',
                            app\models\Currency::getActiveCurrency(true),
                            [
                                'prompt' => Yii::t('app', 'Select'),
                                'class' => 'form-control',
                            ]);
                        ?>
                    </div>
                </div>
                <?=
                $form->field($model, 'budget_item_id')->dropDownList(
                    app\models\BudgetItem::getArrayBudgetItem(\app\models\BudgetItem::TYPE_INCOME),
                    ['prompt' => Yii::t('app', 'Select')]
                ); ?>
                <?php

                ?>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="budgetitem-date">Планируемая дата</label>
                    <div class="col-sm-6">
                        <?=kartik\date\DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'date_income',
                            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'class' => 'col-sm-6'],
                        ])?>
                    </div>
                </div>
                </p>
                <?php $this->endBlock(); ?>

                <?=
                Tabs::widget(
                    [
                        'encodeLabels' => false,
                        'items' => [ [
                            'label'   => 'Доход',
                            'content' => $this->blocks['main'],
                            'active'  => true,
                        ], ]
                    ]
                );
                ?>
                <hr/>
                <?php echo $form->errorSummary($model); ?>
                <?= Html::submitButton(
                    '<span class="glyphicon glyphicon-check"></span> ' .
                    ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
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
