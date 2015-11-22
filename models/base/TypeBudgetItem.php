<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "type_budget_item".
 *
 * @property integer $id
 * @property string $type
 *
 * @property \app\models\BudgetItem[] $budgetItems
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
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\models\BudgetItem::className(), ['type_budget_item_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\TypeBudgetItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TypeBudgetItemQuery(get_called_class());
    }


}
