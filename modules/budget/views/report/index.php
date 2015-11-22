<?php
/**
 * @var \app\models\BudgetHistory[] $models
 * @var \app\models\Report $model
 */
use yii\widgets\ListView;


$this->title = Yii::t('app', 'Report');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="giiant-crud budget-index">

    <?php      echo $this->render('tmpl/_form', ['model' =>$model]);?>

    <div class="clearfix">

        <div class="pull-right">
        </div>
    </div>


    <div class="panel panel-default">


        <div class="panel-body">

            <div class="table-responsive">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!--         income        -->

                    <?php
                    if($models) {

                        foreach($models['models'] as $one) {
                            echo $this->render('tmpl/_operation', ['historyModel'=>$one, 'model'=>$model]);
                        }
                        ?>

                        <hr>
                        <?php
                        echo $this->render('tmpl/_total',[
                            'model'=>$model,
                            'total'=>$models['TOTAL_SUM']
                        ]);
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>

</div>


</div>
