<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/05/2019
 * Time: 15:57
 */

namespace Prestation\Utils;


class BitManipulation
{
    /**
     * @param int[] $days
     * @return int
     */
    static public function getBusinessWeekDaysInt($days){
        //Lundi = 1 //Dimanche = 7
        sort($days);
        $mask = 0;
        foreach ($days as $day) {
            $mask = BitManipulation::setBit($mask, abs($day-7));
        }
        return $mask;
    }

    static  private function setBit($n, $i) {
    return $n | (1 << $i);
    }
}