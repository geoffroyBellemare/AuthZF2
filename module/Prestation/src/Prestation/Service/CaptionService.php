<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/06/2019
 * Time: 14:23
 */

namespace Prestation\Service;


use Prestation\Entity\Caption;

interface CaptionService
{
    /**
     * @param $data
     * @return Caption|null
     */
    public function save($data);
}