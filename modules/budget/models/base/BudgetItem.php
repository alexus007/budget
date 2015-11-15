<?php

namespace app\modules\budget\models\base;

use Yii;

/**
 * This is the base-model class for table "budget_item".
 *
 * @property integer $id
 * @property integer $patent_id
 * @property integer $currency_id
 * @property integer $type_budget_item_id
 * @property string $name
 * @property double $ammount
 * @property integer $active
 *
 * @property \app\modules\budget\models\BudgetHistory[] $budgetHistories
 * @property \app\modules\budget\models\Currency $currency
 * @property \app\modules\budget\models\BudgetItem $patent
 * @property \app\modules\budget\models\BudgetItem[] $budgetItems
 * @property \app\modules\budget\models\TypeBudgetItem $typeBudgetItem
 */
class BudgetItem extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'budget_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patent_id', 'currency_id', 'type_budget_item_id', 'name', 'ammount'], 'required'],
            [['patent_id', 'currency_id', 'type_budget_item_id', 'active'], 'integer'],
            [['ammount'], 'number'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patent_id' => 'Patent ID',
            'currency_id' => 'Currency ID',
            'type_budget_item_id' => 'Type Budget Item ID',
            'name' => 'Name',
            'ammount' => 'Ammount',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetHistories()
    {
        return $this->hasMany(\app\modules\budget\models\BudgetHistory::className(), ['budget_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(\app\modules\budget\models\Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatent()
    {
        return $this->hasOne(\app\modules\budget\models\BudgetItem::className(), ['id' => 'patent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\modules\budget\models\BudgetItem::className(), ['patent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeBudgetItem()
    {
        return $this->hasOne(\app\modules\budget\models\TypeBudgetItem::className(), ['id' => 'type_budget_item_id']);
    }




}
