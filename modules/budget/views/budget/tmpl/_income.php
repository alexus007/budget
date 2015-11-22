<?php
use yii\helpers\Html;
/**
 * @var \app\models\BudgetHistory $model
 */
?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <?php
                if ($rel = $model->getBudgetItem()->one()) {
                    echo Html::a($rel->name, ['budget-item/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                } else {
                    return '';
                }
                ?>
            </div>
            <div class="col-sm-3">
                <?=$model->ammount;?>
                <?=\app\models\Currency::getSign($model->currency_id);?>
            </div>
            <div class="col-sm-3"><?=Yii::$app->formatter->asDate($model->date);?></div>
            <div class="col-sm-2">
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ', ['delete-history', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger btn-xs',
                        'data-confirm' => '' . Yii::t('app', 'Are you sure to delete this item?') . '',
                        'data-method' => 'post',
                    ]); ?>
            </div>
        </div>
    </div>
</div>
