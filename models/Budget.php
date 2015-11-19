<?php

namespace app\models;

use Yii;
use \app\models\base\Budget as BaseBudget;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\components\helpers\CurrentUser;

/**
 * This is the model class for table "budget".
 */
class Budget extends BaseBudget
{


    public function rules()
    {
        return [
            [['currency_id', 'title'], 'required'],
            [['user_id', 'currency_id', 'active'], 'integer'],
            [['costs_limit', 'income_limit'], 'number'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

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

    public function behaviors()
    {
        return [

            // date
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => function($event) {
                    return date('Y-m-d H:i:s');
                }
            ],
            // user
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ]
        ];
    }

    public static function baseQuery()
    {
        $query = Budget::find();

        $query->andWhere(['user_id'=>CurrentUser::getId()]);
        $query->andWhere(['active'=>true]);
        return $query;
    }
}
