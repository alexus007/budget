<?php

namespace app\modules\budget\models\base;

use Yii;

/**
 * This is the base-model class for table "budget".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $currency_id
 * @property string $title
 * @property string $created_date
 * @property string $updated_date
 * @property integer $active
 *
 * @property \app\modules\budget\models\Currency $currency
 * @property \app\modules\budget\models\User $user
 * @property \app\modules\budget\models\BudgetHistory[] $budgetHistories
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
            'id' => 'ID',
            'user_id' => 'User ID',
            'currency_id' => 'Currency ID',
            'title' => 'Title',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'active' => 'Active',
        ];
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
    public function getUser()
    {
        return $this->hasOne(\app\modules\budget\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetHistories()
    {
        return $this->hasMany(\app\modules\budget\models\BudgetHistory::className(), ['budget_id' => 'id']);
    }




}
