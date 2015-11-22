<?php
/**
 * @var \app\models\Budget $budgetModel
 */
?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <b>Итого:</b>
            </div>
            <div class="col-sm-6">
                <b><?php
                    $total = \app\models\BudgetHistory::getTotalSum($budgetModel->id, $type);
                    echo $total['RUB'] . ' ₽<br>';
                    if(isset($total['USD'])) {
                        echo  $total['USD'] . '  $<br>';
                        echo '<small>Сумма в рублях: ' . $total['TOTAL_RUB'] . ' ₽</small>';
                    }
                    ?></b>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <?php
            if($budgetModel->costs_limit && isset($total['TOTAL_RUB']) && ($total['TOTAL_RUB']>$budgetModel->costs_limit)) {
                echo "<span class='alert-danger'>Превышение лимита расходов на " . ($total['TOTAL_RUB'] - $budgetModel->costs_limit) . " ₽</span>";
            }
            ?>
        </div>
    </div>
</div>
