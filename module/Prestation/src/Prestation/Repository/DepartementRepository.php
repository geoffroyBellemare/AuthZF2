<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:21
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface DepartementRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Departement $departement
     * @return int|null
     */
    public function create($departement);

    /**
     * @param $name
     * @return \Prestation\Entity\Departement|null
     */
    public function findByName($name);

    /**
     * @return mixed
     */
    public function fetchAll();

    /**
     * @param $department
     * @return mixed
     */
    public function update($department);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param \Prestation\Entity\Departement $department
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function createRelation($department, $marker);

    /**
     * @param \Prestation\Entity\Departement $department
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function findRelation($departement, $marker);
}