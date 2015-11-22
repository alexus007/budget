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


    const CURRENCY_USD = 11;

    public static function baseQuery()
    {
        $query = self::find();
        $query->andWhere(['active'=>true]);
        return $query;
    }

    public static function getActiveCurrency($chCode = false)
    {
        $attr = 'name';
        $query = Currency::find()->andWhere(['active'=>true])->all();
        if($chCode)
            $attr = 'chCode';
        return ArrayHelper::map($query, 'id', $attr);
    }

    public static function getSign($currency_id)
    {
        if(!$currency_id)
            return;
        $query = self::baseQuery();
        $query->select('sign');
        $query->where(['id'=>$currency_id]);
        return ArrayHelper::getValue($query->one(),'sign');
    }
}
