<?php

namespace app\models;

use Yii;
use \app\models\base\TypeBudgetItem as BaseTypeBudgetItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "type_budget_item".
 */
class TypeBudgetItem extends BaseTypeBudgetItem
{

    public static function getTypes()
    {
        $query = self::find()->all();
        return ArrayHelper::map($query, 'id', 'type');
    }
}
