<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 17:41
 */

namespace Prestation\Utils;


class DateManipulation
{
    static public function convertDateStringToTimeStamp( $dateString ) {

        //Date example$date="2010-07-29 13:24:00";

        $date = date_parse_from_format('Y-m-d H:i:s', $dateString);
        $timestamp = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        return $timestamp;
    }
    static public function convertTimeStampUnixToDateString($unixTimestamp) {
        return date("Y-m-d H:i:s", $unixTimestamp);
    }
    /**
     * @param $dateString
     * @return false|string
     */
    static public function convertDateStringToTime($dateString) {
        $time=strtotime($dateString);
        return date("H:i:s",$time);
    }

    /**
     * @param $dateString
     * @return false|string
     */
    static public function convertDateStringToWeekDay($dateString) {
        return date('N', strtotime($dateString));
    }

    /**
     * @param $dateString
     * @return string
     */
    static public function convertDateStringToDate($dateString) {
        return date('Y-m-d', strtotime($dateString)). ' 00:00:00';
    }

    /**
     * @return array
     */
    static public function getInfinitePeriod() {
        $data = [];
        $data[0] = [];
        $data[0]['start'] = date('Y-m-d', time()). ' 00:00:00';
        $data[0]['end'] = date('Y-m-d', strtotime('+10 years')). ' 23:59:00';
        $data[0]['year'] = date('Y', time());
        $data[0]['business_weekday'] = BitManipulation::getBusinessWeekDaysInt([1,2,3,4,5,6,7]);
        $data[0]['price'] = 0;
        $data[0]['quantity'] = 500;

/*        $data[0]['week_start'] = 1;
        $data[0]['week_end'] = 52;*/

        $data[0]['horaire'][0]['start'] = '2019-05-27 08:00:00';
        $data[0]['horaire'][0]['end'] = '2019-05-27 17:00:00';
        $data[0]['horaire'][1]['start'] = '2019-05-28 08:00:00';
        $data[0]['horaire'][2]['end'] = '2019-05-28 17:00:00';

        return $data;
    }

}