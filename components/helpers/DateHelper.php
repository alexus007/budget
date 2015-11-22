<?php


namespace app\components\helpers;

/**
 *  Фичи с датами
 */
class DateHelper
{

    public static $month
        = array(
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        );

    public static function getLongRuMonthName($number)
    {
        return mb_strtolower(self::$month[(int)$number - 1], 'UTF-8');
    }

    public static function yesterday()
    {
        return self::period('-1 day');
    }

    public static function begin($date)
    {
        return date("Y-m-d 00:00:00", strtotime($date));
    }

    public static function strToTime($string)
    {
        $translation = array(
            "am"        => "дп",
            "pm"        => "пп",
            "AM"        => "ДП",
            "PM"        => "ПП",
            "Monday"    => "Понедельник",
            "Mon"       => "Пн",
            "Tuesday"   => "Вторник",
            "Tue"       => "Вт",
            "Wednesday" => "Среда",
            "Wed"       => "Ср",
            "Thursday"  => "Четверг",
            "Thu"       => "Чт",
            "Friday"    => "Пятница",
            "Fri"       => "Пт",
            "Saturday"  => "Суббота",
            "Sat"       => "Сб",
            "Sunday"    => "Воскресенье",
            "Sun"       => "Вс",
            "January"   => "января",
            "Jan"       => "янв",
            "February"  => "февраля",
            "Feb"       => "фев",
            "March"     => "марта",
            "Mar"       => "мар",
            "April"     => "апреля",
            "Apr"       => "апр",
            "May"       => "мая",
            "June"      => "июня",
            "Jun"       => "июн",
            "July"      => "июля",
            "Jul"       => "июл",
            "August"    => "августа",
            "Aug"       => "авг",
            "September" => "сентября",
            "Sep"       => "сен",
            "October"   => "октября",
            "Oct"       => "окт",
            "November"  => "ноября",
            "Nov"       => "ноя",
            "December"  => "декабря",
            "Dec"       => "дек",
            "st"        => "ое",
            "nd"        => "ое",
            "rd"        => "е",
            "th"        => "ое"
        );
        $result = strtr($string, array_flip($translation));
        return strtotime($result);
    }

    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

    public static function end($date)
    {
        return date("Y-m-d 23:59:59", strtotime($date));
    }

    public static function period($period)
    {
        return date("Y-m-d H:i:s", strtotime($period));
    }

    public static function reformat($date)
    {
        return date("Y-m-d H:i:s", strtotime($date));
    }

}