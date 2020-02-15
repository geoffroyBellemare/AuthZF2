<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 16:56
 */

namespace Prestation\Utils;


trait Fields
{
    public $reservationFields = [
        'user_id',
        'p_id',
        'pr_id',
        'rv_id',
        'rv_start',
        'rv_end',
        'rv_quantity'
    ];
    public $prestationFields = [
        'p_id',
        'p_name',
        'p_price',
        'p_quantity',
        'user_id',
        't_id',
        'k_id',
        'm_id',
        'ad_id',
        'capt_id',
        'p_created'
    ];
}