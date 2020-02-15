<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 16:05
 */

namespace Prestation\Service;


interface KeywordService
{
    /**
     * @param $e_id
     * @param $keyword
     * @param [] $aliases
     * @return \Prestation\Entity\Keyword|null
     */
    public  function save($e_id, $keyword, $aliases = null);
}