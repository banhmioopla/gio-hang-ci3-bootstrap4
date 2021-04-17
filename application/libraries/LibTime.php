<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibTime {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function calDayInMonthThisYear($month) {
        return cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
    }

    public function standardizedFormat($time_str) {
        return str_replace('/', '-', $time_str);
    }

    public function unixTimeFormat($time_str) {
        return strtotime(str_replace('/', '-', $time_str));
    }

    public function formatDMY($time) {
        if(is_numeric($time)) {
            return date('d/m/Y', $time);
        }
        $unix_time = strtotime(str_replace('/', '-', $time));
        return date('d/m/Y', $unix_time);
    }


}






?>