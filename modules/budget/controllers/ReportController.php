<?php

namespace app\modules\budget\controllers;

use app\models\Report;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use Yii;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $model = new Report();
        $models = null;
        try {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $models = $model->search();
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('index', ['model'=>$model,'models'=>$models]);
    }

}
