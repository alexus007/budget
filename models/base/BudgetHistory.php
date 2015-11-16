<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "budget_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $budget_id
 * @property integer $budget_item_id
 * @property double $ammount
 * @property string $date
 *
 * @property \app\models\Budget $budget
 * @property \app\models\BudgetItem $budgetItem
 * @property \app\models\User $user
 */
class BudgetHistory extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'budget_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'budget_id', 'budget_item_id', 'ammount', 'date'], 'required'],
            [['user_id', 'budget_id', 'budget_item_id'], 'integer'],
            [['ammount'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'budget_id' => Yii::t('app', 'Budget ID'),
            'budget_item_id' => Yii::t('app', 'Budget Item ID'),
            'ammount' => Yii::t('app', 'Ammount'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudget()
    {
        return $this->hasOne(\app\models\Budget::className(), ['id' => 'budget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItem()
    {
        return $this->hasOne(\app\models\BudgetItem::className(), ['id' => 'budget_item_id']);
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
     * @return \app\models\query\BudgetHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BudgetHistoryQuery(get_called_class());
    }


}
