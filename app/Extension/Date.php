<?php
/*
 * Extension Date
 * Copyright (c) Shaoransoft
*/
namespace App\Extension;

class Date
{
    public static $day_short_eng = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    public static $day_long_eng = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    public static $month_short_eng = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    public static $month_long_eng = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    public static $day_short_tha = ['จ.','อ.','พ.','พฤ.','ศ.','ส.','อา.'];
    public static $day_long_tha = ['จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์'];
    public static $month_short_tha = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
    public static $month_long_tha = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];

    public static function date_between(string $start, string $end, bool $add_one_day = false)
    {
        if (!$start || !$end) return 0;
        return round(abs(strtotime($start) - strtotime($end)) / 86400) + ($add_one_day ? 1 : 0);
    }

    public static function thai_format(string $date, $format = 'd/m/y')
    {
        $ts = strtotime(is_null($date) ? 'now' : $date);
        if (mb_strpos($format, 'o') !== false)
            $format = str_replace('o', (date('o', $ts) + 543), $format);
        if (mb_strpos($format, 'Y') !== false)
            $format = str_replace('Y', (date('Y', $ts) + 543), $format);
        if (mb_strpos($format, 'y') !== false)
            $format = str_replace('y', (date('y', $ts) + 43), $format);
      
        $n = (date('n', $ts) - 1);
        if (mb_strpos($format, 'F') !== false && array_key_exists($n, Date::$month_long_tha))
            $format = str_replace('F', Date::$month_long_tha[$n], $format);
        if (mb_strpos($format, 'M') !== false && array_key_exists($n, Date::$month_short_tha))
            $format = str_replace('M', Date::$month_short_tha[$n], $format);
        if (mb_strpos($format, 'm') !== false)
            $format = str_replace('m', date('m', $ts), $format);
      
        $w = date('w', $ts);
        if (mb_strpos($format, 'l') !== false && array_key_exists($w, Date::$day_long_tha))
            $format = str_replace('l', Date::$day_long_tha[$w], $format);
        if (mb_strpos($format, 'D') !== false && array_key_exists($w, Date::$day_short_tha))
            $format = str_replace('D', Date::$day_short_tha[$w], $format);
        if (mb_strpos($format, 'd') !== false)
            $format = str_replace('d', date('d', $ts), $format);
      
        if (mb_strpos($format, 'H') !== false)
            $format = str_replace('H', date('H', $ts), $format);
        if (mb_strpos($format, 'h') !== false)
            $format = str_replace('h', date('h', $ts), $format);
        if (mb_strpos($format, 'i') !== false)
            $format = str_replace('i', date('i', $ts), $format);
        if (mb_strpos($format, 's') !== false)
            $format = str_replace('s', date('s', $ts), $format);
        return $format;
    }

    public static function thai_range_format($date1, $format = 'd/m/y', $date2 = null, $separator = ' - ')
    {
        $ts1 = strtotime(is_null($date1) ? 'now' : $date1);
        $ts2 = strtotime(is_null($date2) ? 'now' : $date2);
        $Y1 = date('Y', $ts1);
        $Y2 = date('Y', $ts2);
        $m1 = date('m', $ts1);
        $m2 = date('m', $ts2);
        $d1 = date('d', $ts1);
        $d2 = date('d', $ts2);
        $c = [];
        if ($Y1 == $Y2 && $m1 == $m2 && $d1 == $d2)
            return Date::thai_format($format, $date1);
        if ($Y1 == $Y2 && $m1 == $m2)
            $c = ['o','Y','y','F','M','m'];
        if ($Y1 == $Y2 && $m1 != $m2)
            $c = ['o','Y','y'];
        return Date::thai_format(str_replace($c, '', $format), $date1).$separator.Date::thai_format($format, $date2);
    }
}
?>