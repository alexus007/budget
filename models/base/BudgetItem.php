<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "budget_item".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property integer $currency_id
 * @property integer $type_budget_item_id
 * @property string $name
 * @property string $ammount
 * @property string $date
 * @property integer $active
 *
 * @property \app\models\BudgetHistory[] $budgetHistories
 * @property \app\models\Currency $currency
 * @property \app\models\BudgetItem $parent
 * @property \app\models\BudgetItem[] $budgetItems
 * @property \app\models\TypeBudgetItem $typeBudgetItem
 * @property \app\models\User $user
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
            [['parent_id', 'user_id', 'currency_id', 'type_budget_item_id', 'active'], 'integer'],
            [['user_id', 'currency_id', 'type_budget_item_id', 'name'], 'required'],
            [['ammount'], 'number'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'type_budget_item_id' => Yii::t('app', 'Type Budget Item ID'),
            'name' => Yii::t('app', 'Name'),
            'ammount' => Yii::t('app', 'Ammount'),
            'date' => Yii::t('app', 'Date'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetHistories()
    {
        return $this->hasMany(\app\models\BudgetHistory::className(), ['budget_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(\app\models\Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\BudgetItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\models\BudgetItem::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeBudgetItem()
    {
        return $this->hasOne(\app\models\TypeBudgetItem::className(), ['id' => 'type_budget_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\BudgetItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BudgetItemQuery(get_called_class());
    }


}
