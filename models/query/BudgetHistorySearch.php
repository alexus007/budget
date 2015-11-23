<?php

namespace app\models\query;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BudgetHistory;

/**
 * BudgetHistorySearch represents the model behind the search form about `app\models\BudgetHistory`.
 */
class BudgetHistorySearch extends BudgetHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'budget_id', 'budget_item_id'], 'integer'],
            [['ammount'], 'number'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BudgetHistory::baseQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'budget_id' => $this->budget_id,
            'budget_item_id' => $this->budget_item_id,
            'currency_id'   => $this->currency_id,
            'ammount' => $this->ammount,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }

    public function searchItems($budget_id, $type, $params)
    {
        $query = BudgetHistory::baseQuery();
        $query->joinWith([
            'budgetItem'
        ]);
        $query->andWhere(['budget_history.budget_id'=>$budget_id]);
        $query->andWhere(['budget_item.type_budget_item_id'=>$type]);
        $query->orderBy([
            'date' => SORT_ASC
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}