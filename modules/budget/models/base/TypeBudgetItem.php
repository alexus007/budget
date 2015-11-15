<?php

namespace app\modules\budget\models\base;

use Yii;

/**
 * This is the base-model class for table "type_budget_item".
 *
 * @property integer $id
 * @property string $type
 *
 * @property \app\modules\budget\models\BudgetItem[] $budgetItems
 */
class TypeBudgetItem extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_budget_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\modules\budget\models\BudgetItem::className(), ['type_budget_item_id' => 'id']);
    }




}
