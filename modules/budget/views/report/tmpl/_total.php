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
                <b><span class="alert-danger">
                <?php
                if(isset($total['cost']) && $model->type_id == 2) {
                    echo '- ' . number_format($total['cost'], 2) . ' ';?><?=app\models\Currency::getSign($model->currency_id);
                }
                ?>
                    </span></b>&nbsp;
                <b><span class="alert-success">
                    <?php
                    if(isset($total['income']) && $model->type_id == 1) {
                        echo number_format($total['income'], 2) . ' ';?><?=app\models\Currency::getSign($model->currency_id);
                    }
                    ?>
                    </span></b>
                <?php
                    if($model->type_id == 0) {
                ?>
                        <b><span class="alert-danger">
                <?php
                if(isset($total['cost'])) {
                    echo '- ' . number_format($total['cost'], 2) . ' ';?><?=app\models\Currency::getSign($model->currency_id);
                }
                ?>
                    </span></b>&nbsp;
                        <b><span class="alert-success">
                    <?php
                    if(isset($total['income'])) {
                        echo number_format($total['income'], 2) . ' ';?><?=app\models\Currency::getSign($model->currency_id);
                    }
                    ?>
                    </span></b>
                <?php }?>
            </div>
        </div>
    </div>
</div>
