<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 11:12
 */

namespace Prestation\Service;


interface CountryService
{
    /**
     * @param array $data
     * @return \Prestation\Entity\Country
     */
    public function save($data);
}