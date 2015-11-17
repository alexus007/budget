<?php

namespace app\modules\budget\controllers;

use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
