<?php
namespace app\components\helpers;

use \app\models\CurrencyCur;

class CurrencyConverter
{

    public static function currencyAsRub($currency_id, $ammount)
    {
        if(!$currency_id && !$ammount)
            return;
        if($currency_id == 1)
            return $ammount;
        $query = CurrencyCur::find();
        $query->where(['currency_id'=>$currency_id]);
        $query->orderBy(['id'=>SORT_DESC]);
        $query->limit(1);
        $rate = $query->one();
        if($rate)
            return $ammount * $rate->rate;
        else
            return false;
    }

    public static function rubAsCurrency($currency_id, $ammount)
    {
        if(!$currency_id && !$ammount)
            return;
        $query = CurrencyCur::find();
        $query->where(['currency_id'=>$currency_id]);
        $query->orderBy(['id'=>SORT_DESC]);
        $query->limit(1);
        $rate = $query->one();
        if($rate)
            return $ammount / $rate->rate;
        else
            return false;

    }

}