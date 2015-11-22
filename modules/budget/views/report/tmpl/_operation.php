<?php
use yii\helpers\Html;
use app\components\helpers\CurrencyConverter;
/**
 * @var \app\models\BudgetHistory $historyModel
 * @var \app\models\Report $model
 */
?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <?php
                if ($rel = $historyModel->getBudgetItem()->one()) {
                    echo Html::a($rel->name, ['budget-item/view', 'id' => $rel->id,], ['data-pjax' => 0]);

                    $relAmmount = CurrencyConverter::currencyAsRub($rel->currency_id, $rel->ammount);
                    $modelAmmount = CurrencyConverter::currencyAsRub($historyModel->currency_id, $historyModel->ammount);
                    if($rel->ammount && ($modelAmmount > $relAmmount)) {
                        echo "<br><span class='alert-danger'>Превышение лимита по статье на " . ($modelAmmount - $relAmmount) . " ₽</span>";
                    }
                } else {
                    return '';
                }
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                    if($model->currency_id == 1){
                        if($historyModel->currency_id == 1)
                            echo $historyModel->ammount;
                        else
                            echo CurrencyConverter::currencyAsRub($historyModel->currency_id, $historyModel->ammount);
                    }else{
                        if($historyModel->currency_id != 1)
                            echo $historyModel->ammount;
                        else
                            echo number_format(CurrencyConverter::rubAsCurrency($model->currency_id, $historyModel->ammount),2);
                    }
                ?>
                <?=\app\models\Currency::getSign($model->currency_id);?>
            </div>
            <div class="col-sm-3"><?=Yii::$app->formatter->asDate($historyModel->date);?></div>
        </div>
    </div>
</div>