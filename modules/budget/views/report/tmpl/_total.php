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
                <b><?php echo number_format($total, 2) . ' ';?><?=app\models\Currency::getSign($model->currency_id)?></b>
            </div>
        </div>
    </div>
</div>
