<?php

namespace app\models;

use app\components\behaviors\Tree;
use app\components\helpers\DateHelper;
use app\models\query\BudgetItemSearch;
use Yii;
use \app\models\base\BudgetItem as BaseBudgetItem;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\components\helpers\CurrentUser;

/**
 * This is the model class for table "budget_item".
 *
 * @method \app\components\behaviors\Tree getChildsArray
 * @method \app\components\behaviors\Tree getTabList
 * @method  \app\components\behaviors\Tree  getTreeAssocList
 */
class BudgetItem extends BaseBudgetItem
{

    const TYPE_INCOME = 1;
    const TYPE_COST = 2;


    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'currency_id', 'type_budget_item_id', 'active'], 'integer'],
            [['currency_id', 'type_budget_item_id', 'name'], 'required'],
            [['ammount'], 'number'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'type_budget_item_id' => Yii::t('app', 'Type Budget Item ID'),
            'name' => Yii::t('app', 'Name'),
            'ammount' => Yii::t('app', 'Ammount Limit'),
            'date' => Yii::t('app', 'Planned Date'),
            'active' => Yii::t('app', 'Active'),
        ];
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
                    return ($this->date) ? DateHelper::reformat($this->date) : null;
                }
            ],
            // user
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            // tree
            [
                'class' => Tree::className(),
                'titleAttribute' => 'name',
                'aliasAttribute' => 'id',
                'defaultCriteria' => self::baseQuery(),
            ]
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $childs = $this->getChildsArray();
            self::deleteAll(['id' => $childs]);
            return true;
        } else {
            return false;
        }
    }

    public static function baseQuery()
    {
        $query = BudgetItem::find();

        $query->andWhere(['user_id'=>CurrentUser::getId()]);
        $query->andWhere(['active'=>true]);
        return $query;
    }


    public static function getTypes()
    {
        return [
            self::TYPE_INCOME => 'Доход',
            self::TYPE_COST => 'Расход',
        ];
    }

    public static function getTypesCssClass()
    {
        return [
            self::TYPE_INCOME => 'success',
            self::TYPE_COST => 'danger',
        ];
    }

    public function getTypeBudgetItemType()
    {
        return ArrayHelper::getValue(self::getTypes(), $this->type_budget_item_id);
    }


    public static function getArrayBudgetItem($type)
    {
        if(!$type && ($type !== self::TYPE_COST || $type !== self::TYPE_INCOME))
            return false;
        $query = self::baseQuery();
        $query->where(['type_budget_item_id'=>$type, 'parent_id' => null]);
        $query->orderBy(['id'=>SORT_ASC]);
        $parents = $query->all();
        $result = [];
        if($parents) {
            foreach($parents as $parent){
                $result = ArrayHelper::merge($result, (new BudgetItem())->getTreeAssocList($parent->id));
            }
            return $result;
        } else
            return $result;
    }
}
