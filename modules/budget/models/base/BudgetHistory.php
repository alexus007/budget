<?php

namespace app\modules\budget\models\base;

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
 * @property \app\modules\budget\models\Budget $budget
 * @property \app\modules\budget\models\BudgetItem $budgetItem
 * @property \app\modules\budget\models\User $user
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
            'id' => 'ID',
            'user_id' => 'User ID',
            'budget_id' => 'Budget ID',
            'budget_item_id' => 'Budget Item ID',
            'ammount' => 'Ammount',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudget()
    {
        return $this->hasOne(\app\modules\budget\models\Budget::className(), ['id' => 'budget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItem()
    {
        return $this->hasOne(\app\modules\budget\models\BudgetItem::className(), ['id' => 'budget_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\modules\budget\models\User::className(), ['id' => 'user_id']);
    }




}
