<?php
namespace app\models;

use app\components\helpers\CurrencyConverter;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use app\components\helpers\DateHelper;
use Yii;

class Report extends Model
{

    public $budget_id;
    public $type_id;
    public $currency_id;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['budget_id','type_id', 'date_from', 'date_to', 'currency_id'], 'required'],
            [['date_from', 'date_to'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'budget_id' => Yii::t('app', 'Budget ID'),
            'type_id'   => Yii::t('app', 'Type Budget Item ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'date_from' => Yii::t('app', 'Date form'),
            'date_to' => Yii::t('app', 'Date to'),
        ];
    }

    public function search()
    {
        $query = BudgetHistory::baseQuery();
        $query->joinWith([
            'budgetItem'
        ]);
        if($this->type_id && ($this->type_id != 0))
            $query->andWhere(['budget_item.type_budget_item_id'=>$this->type_id]);

        $query->andWhere(['>=', 'budget_history.date', $this->date_from ? DateHelper::begin($this->date_from) : null])
            ->andWhere(['<=', 'budget_history.date', $this->date_to ? DateHelper::end($this->date_to) : null]);
        $query->orderBy([
            'date' => SORT_ASC
        ]);
        $result = ['models'=>[], 'TOTAL_SUM' => ['cost'=>0, 'income'=>0]];
        $models = $query->all();
        if($models) {
            $result['models'] = $models;
            $sumCost = 0;
            $sumIncome = 0;
            foreach($models as $model) {

                if($model->budgetItem->type_budget_item_id == 2) {
                    // rub
                    if($this->currency_id == 1 && ($model->currency_id == 1)) {
                        $sumCost += $model->ammount;
                    } elseif($this->currency_id == 1 && ($model->currency_id != 1)) {
                        $sumCost += CurrencyConverter::currencyAsRub($model->currency_id, $model->ammount);
                    }elseif($this->currency_id != 1 && ($model->currency_id == 1)) {
                        $sumCost += CurrencyConverter::rubAsCurrency($this->currency_id,$model->ammount);
                    } elseif($this->currency_id != 1 && ($model->currency_id != 1)) {
                        $sumCost += $model->ammount;
                    }
                } else {
                    // rub
                    if($this->currency_id == 1 && ($model->currency_id == 1)) {
                        $sumIncome += $model->ammount;
                    } elseif($this->currency_id == 1 && ($model->currency_id != 1)) {
                        $sumIncome += CurrencyConverter::currencyAsRub($model->currency_id, $model->ammount);
                    }elseif($this->currency_id != 1 && ($model->currency_id == 1)) {
                        $sumIncome += CurrencyConverter::rubAsCurrency($this->currency_id,$model->ammount);
                    } elseif($this->currency_id != 1 && ($model->currency_id != 1)) {
                        $sumIncome += $model->ammount;
                    }
                }
            }

            $result['TOTAL_SUM'] = [ 'cost'=>$sumCost, 'income'=>$sumIncome];

        }
        return $result;
    }

}