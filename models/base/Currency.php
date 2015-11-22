<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $chCode
 * @property string $sign
 * @property integer $active
 *
 * @property \app\models\BudgetHistory[] $budgetHistories
 * @property \app\models\BudgetItem[] $budgetItems
 * @property \app\models\CurrencyCur[] $currencyCurs
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
            [['name', 'code', 'chCode', 'sign'], 'required'],
            [['code', 'active'], 'integer'],
            [['name', 'chCode', 'sign'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'chCode' => Yii::t('app', 'Ch Code'),
            'sign' => Yii::t('app', 'Sign'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetHistories()
    {
        return $this->hasMany(\app\models\BudgetHistory::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\models\BudgetItem::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyCurs()
    {
        return $this->hasMany(\app\models\CurrencyCur::className(), ['currency_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CurrencyQuery(get_called_class());
    }


}
