<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 14:49
 */

namespace Prestation\Service;


interface TypeService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function save($data);
}