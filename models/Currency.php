<?php

namespace app\models;

use Yii;
use \app\models\base\Currency as BaseCurrency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency".
 */
class Currency extends BaseCurrency
{

    public static function getActiveCurrency()
    {
        $query = Currency::find()->andWhere(['active'=>true])->all();
        return ArrayHelper::map($query, 'id', 'name');
    }
}
