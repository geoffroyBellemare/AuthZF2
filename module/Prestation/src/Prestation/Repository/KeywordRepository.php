<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 15:17
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface KeywordRepository extends RepositoryInterface
{
    /**
     * @param $keyword
     * @return \Prestation\Entity\Keyword
     */
    public function create($keyword);

    /**
     * @param $name
     * @return \Prestation\Entity\Keyword|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @param $k_id
     * @param $e_id
     * @return mixed
     */
    public function createRelation($id, $e_id, $k_id);
}