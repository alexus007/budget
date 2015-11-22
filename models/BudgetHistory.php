<?php

namespace app\models;

use app\components\helpers\CurrencyConverter;
use Yii;
use \app\models\base\BudgetHistory as BaseBudgetHistory;
use app\components\helpers\CurrentUser;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\components\helpers\DateHelper;

/**
 * This is the model class for table "budget_history".
 */
class BudgetHistory extends BaseBudgetHistory
{

    public $date_income;
    public $date_costs;

    public function rules()
    {
        return [
            [['budget_id', 'budget_item_id', 'currency_id', 'ammount'], 'required'],
            [['user_id', 'budget_id', 'budget_item_id', 'currency_id'], 'integer'],
            [['ammount'], 'number'],
            [['date', 'date_income', 'date_costs'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'budget_id' => Yii::t('app', 'Budget ID'),
            'budget_item_id' => Yii::t('app', 'Budget Item ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'ammount' => Yii::t('app', 'Ammount'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public static function baseQuery()
    {
        $query = BudgetHistory::find();

        $query->where(['budget_history.user_id'=>CurrentUser::getId()]);
        return $query;
    }

    public function beforeValidate()
    {
        if(isset($this->date_income) || $this->date_costs){
            $this->date = ($this->date_income) ? $this->date_income : $this->date_costs;
        }
        return parent::beforeValidate();
    }

    public function behaviors()
    {
        return [

            // date
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'date',
                'value' => function($event) {
                    return ($this->date) ? DateHelper::reformat($this->date) : DateHelper::now();
                }
            ],
            // user
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    public static function getTotalSum($budget_id, $type)
    {
        $query = self::baseQuery();
        $query->joinWith([
            'budgetItem'
        ]);
        $query->andWhere(['budget_history.budget_id'=>$budget_id]);
        $query->andWhere(['budget_item.type_budget_item_id'=>$type]);
        $history = $query->all();
        $result = ['RUB'=>0];
        if($history) {
            $sum = 0;
            $totalRub = 0;
            $totalCurrency = 0;
            foreach($history as $one) {
                $currency = $one->currency;
                // rub
                if($currency && ((int)$currency->code == 643)) {
                    $totalRub += floatval($one->ammount);
                    $result['RUB'] = $totalRub;
                } elseif($currency){
                    $totalCurrency += floatval($one->ammount);
                    $result = array_merge($result, [
                        $currency->chCode => $totalCurrency
                    ]);
                    $sum += CurrencyConverter::currencyAsRub($currency->id, $one->ammount);
                }

                $result = array_merge($result, ['TOTAL_RUB'=>$sum + $totalRub]);
            }
        }
        return $result;
    }
}
