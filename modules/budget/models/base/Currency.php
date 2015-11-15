<?php

namespace app\modules\budget\models\base;

use Yii;

/**
 * This is the base-model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property string $sign
 * @property integer $active
 *
 * @property \app\modules\budget\models\Budget[] $budgets
 * @property \app\modules\budget\models\BudgetItem[] $budgetItems
 */
class Currency extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sign'], 'required'],
            [['active'], 'integer'],
            [['name', 'sign'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sign' => 'Sign',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgets()
    {
        return $this->hasMany(\app\modules\budget\models\Budget::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\modules\budget\models\BudgetItem::className(), ['currency_id' => 'id']);
    }




}
