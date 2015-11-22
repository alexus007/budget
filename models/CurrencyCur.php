<?php

namespace app\models;

use Yii;
use \app\models\base\CurrencyCur as BaseCurrencyCur;

/**
 * This is the model class for table "currency_curs".
 */
class CurrencyCur extends BaseCurrencyCur
{

    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $this->date = date('Y-m-d H:i:s');
                return true;
            }
        }
        return false;
    }
}
