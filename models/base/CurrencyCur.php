<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "currency_curs".
 *
 * @property integer $id
 * @property integer $currency_id
 * @property integer $nom
 * @property string $curs
 * @property string $rate
 * @property string $date
 *
 * @property \app\models\Currency $currency
 */
class CurrencyCur extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency_curs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'nom', 'curs', 'rate', 'date'], 'required'],
            [['currency_id', 'nom'], 'integer'],
            [['curs', 'rate'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'nom' => Yii::t('app', 'Nom'),
            'curs' => Yii::t('app', 'Curs'),
            'rate' => Yii::t('app', 'Rate'),
            'date' => Yii::t('app', 'Date'),
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
     * @inheritdoc
     * @return \app\models\query\CurrencyCurQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CurrencyCurQuery(get_called_class());
    }


}
