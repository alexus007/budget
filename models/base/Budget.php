<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "budget".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $currency_id
 * @property string $title
 * @property string $costs_limit
 * @property string $income_limit
 * @property string $created_date
 * @property string $updated_date
 * @property integer $active
 *
 * @property \app\models\Currency $currency
 * @property \app\models\User $user
 * @property \app\models\BudgetHistory[] $budgetHistories
 */
class Budget extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'budget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'currency_id', 'title', 'created_date', 'updated_date'], 'required'],
            [['user_id', 'currency_id', 'active'], 'integer'],
            [['costs_limit', 'income_limit'], 'number'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 255]
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
            'currency_id' => Yii::t('app', 'Currency ID'),
            'title' => Yii::t('app', 'Title'),
            'costs_limit' => Yii::t('app', 'Costs Limit'),
            'income_limit' => Yii::t('app', 'Income Limit'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'active' => Yii::t('app', 'Active'),
        ];
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
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetHistories()
    {
        return $this->hasMany(\app\models\BudgetHistory::className(), ['budget_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\BudgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BudgetQuery(get_called_class());
    }


}
