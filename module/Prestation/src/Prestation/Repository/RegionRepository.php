<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 12:55
 */

namespace Prestation\Repository;


use Application\Repository\RepositoryInterface;

interface RegionRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Region $region
     * @return mixed
     */
    public function create($region);

    /**
     * @param \Prestation\Entity\Region $region
     * @return mixed
     */
    public function update($region);

    /**
     * @param $id
     * @return array
     */
    public function findById($id);

    /**
     * @param string $name
     * @return \Prestation\Entity\Region|null
     */
    public function findByName($name);
    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function createRelation($region, $marker);
    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed|null
     */
    public function findRelation($region, $marker);
}