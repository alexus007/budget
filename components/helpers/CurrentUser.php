<?php

namespace app\components\helpers;

use Yii;
use app\models\User;

class CurrentUser
{

    public static function isGuest()
    {
        $user = Yii::$app->get('user', false);
        return $user->isGuest;
    }

    public static function webUser()
    {
        return Yii::$app->get('user', false);
    }

    /**
        * @return User
        */
    public static function get()
    {
        $user = User::findIdentity(self::webUser()->id);
        return ($user) ? $user : null;

    }

    /**
        * @return  int $id|null
        */
    public static function getId()
    {
        $user = self::get();
        return ($user) ? $user->id : null;
    }
}