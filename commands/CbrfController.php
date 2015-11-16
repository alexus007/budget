<?php

namespace app\commands;

use app\models\base\Currency;
use app\models\CurrencyCur;
use yii\console\Controller;
use Yii;

class CbrfController extends Controller
{

    public $rates = ['byChCode' => [], 'byCode' => []];
    public $currency = [];
    public $soapUrl = '';

    public function actionIndex()
    {
        echo 'yii cbrf/initial-currency' . PHP_EOL;
        echo 'yii cbrf/update-rates' . PHP_EOL;
    }

    public function init()
    {
        parent::init();
        if (!isset($date)) $date = date("Y-m-d");
        $this->soapUrl = Yii::$app->params['cbrfSOAPURL'];

        $client = new \SoapClient($this->soapUrl);



        $curs = $client->GetCursOnDate(array("On_date" => $date));
        $rates = new \SimpleXMLElement($curs->GetCursOnDateResult->any);

        foreach ($rates->ValuteData->ValuteCursOnDate as $rate)
        {
            $rateArray = [];
            $rateArray['name'] = (string)$rate->Vname;
            $rateArray['code'] = (int)$rate->Vcode;
            $rateArray['chCode'] = (string)$rate->VchCode;

            $this->currency[] = $rateArray;

            $r = (float)$rate->Vcurs / (int)$rate->Vnom;
            $this->rates['byChCode'][(string)$rate->VchCode] = ['rate'=>$r, 'curs'=>(float)$rate->Vcurs, 'nom'=>(int)$rate->Vnom];
            $this->rates['byCode'][(int)$rate->Vcode] = ['rate'=>$r, 'curs'=>(float)$rate->Vcurs, 'nom'=>(int)$rate->Vnom];
        }

        // Adding an exchange rate of Russian Ruble
        $this->rates['byChCode']['RUB'] = 1;
        $this->rates['byCode'][643] = 1;
    }

    public function GetRate($code)
    {
        if (is_string($code))
        {
            $code = strtoupper(trim($code));
            return (isset($this->rates['byChCode'][$code])) ? $this->rates['byChCode'][$code] : false;

        }
        elseif (is_numeric($code))
        {
            return (isset($this->rates['byCode'][$code])) ? $this->rates['byCode'][$code] : false;
        }
        else
        {
            return false;
        }
    }

    /**
        * This method returns the array of exchange rates
        *
        * @return array The exchange rates
        */
    public function GetRates()
    {
        return $this->rates;
    }

    public function actionInitialCurrency()
    {
        $inserted = 0;

        if(!empty($this->currency)) {

            // RUB
            $model1 = new Currency();
            $model1->name = 'Российский Рубль';
            $model1->code = 643;
            $model1->chCode = 'RUB';
            $model1->sign = '₽';
            $model1->active = true;
            $model1->save(false);
            $inserted = 1;
            foreach ($this->currency as $currency) {
                $model = new Currency();
                $model->name = $currency['name'];
                $model->code = $currency['code'];
                $model->chCode = $currency['chCode'];
                // USD
                if($currency['code'] == 840) {
                    $model->sign = '$';
                    $model->active = true;

                } else {
                    $model->active = false;
                }

                $model->save(false);
                $inserted++;

            }

        } else {
            $model = new Currency();
            $model->name = 'Российский Рубль';
            $model->code = 643;
            $model->chCode = 'RUB';
            $model->sign = '₽';
            $model->active = true;
            $model->save(false);
            $model1 = new Currency();
            $model1->name = 'Доллар США';
            $model1->code = 840;
            $model1->chCode = 'USD';
            $model1->sign = '$';
            $model1->active = true;
            $model1->save(false);
            $inserted = 2;
        }

        echo "Insert Currency: " . $inserted . PHP_EOL;;

    }

    public function actionUpdateRates($active=null)
    {

        $models = ($active && $active== true) ? Currency::findAll(['active'=>1]) : Currency::find()->all();
        $i = 0;
        foreach($models as $currency)
        {
            if($currency->code == 643)
                continue;
            /** @var \app\models\Currency $currency */
            $currencyModel = CurrencyCur::find()
                ->with('currency')
                ->where('date < :now', [':now' => date('Y-m-d')])
                ->orderBy(['date' => SORT_DESC])
                ->limit(1)
                ->one();
            if(!$currencyModel) {
                if(($rate = $this->GetRate($currency->code))!== false) {

                    $curs = new CurrencyCur();
                    $curs->currency_id = $currency->id;
                    $curs->curs = floatval($rate['curs']);
                    $curs->nom = (int)$rate['nom'];
                    $curs->rate = floatval($rate['rate']);
                    $curs->save(false);
                    $i++;

                }
            }
        }

        echo "Insert currency_curs: " . $i . PHP_EOL;

    }

}