<?php

namespace app\models\query;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BudgetItem;

/**
* BudgetItemSearch represents the model behind the search form about `app\models\BudgetItem`.
*/
class BudgetItemSearch extends BudgetItem
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'patent_id', 'currency_id', 'type_budget_item_id', 'active'], 'integer'],
            [['name', 'date'], 'safe'],
            [['ammount'], 'number'],
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
$query = BudgetItem::find();

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
            'patent_id' => $this->patent_id,
            'currency_id' => $this->currency_id,
            'type_budget_item_id' => $this->type_budget_item_id,
            'ammount' => $this->ammount,
            'date' => $this->date,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

return $dataProvider;
}
}