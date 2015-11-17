<?php

namespace app\models;

use Yii;
use \app\models\base\Budget as BaseBudget;

/**
 * This is the model class for table "budget".
 */
class Budget extends BaseBudget
{


    public function rules()
    {
        return [
            [['id', 'user_id', 'currency_id', 'active'], 'integer'],
            [['title', 'created_date', 'updated_date'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = Yii::$app->user->identity->getId();
                $this->created_date = date('Y-m-d H:i:s');
                $this->updated_date = date('Y-m-d H:i:s');
            } else {
                $this->updated_date = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

}
