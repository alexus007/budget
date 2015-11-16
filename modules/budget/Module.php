<?php

namespace app\modules\budget;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\budget\controllers';

    public $layout = '@app/views/layouts/budget';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
