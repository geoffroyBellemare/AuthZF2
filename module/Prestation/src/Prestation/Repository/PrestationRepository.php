<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/09/2018
 * Time: 19:15
 */

namespace Prestation\Repository;


use Prestation\Entity\Prestation;

interface PrestationRepository extends RepositoryInterface
{
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function update(Prestation $prestation);

    /**
     * @param [] $data
     * @return false|mixed
     */
    public function isFree($data);

    /**
     * @param $data
     * @return false|mixed
     */
    public function isRecordExist($data);

    /**
     * @param \Prestation\Entity\Marker $marker
     * @param \Prestation\Entity\Prestation $prestation
     * @return mixed
     */
    public function create($marker, $prestation);

    /**
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function save($prestation);

    /**
     * @param $value
     * @return mixed
     */
    public function search($value);
    /**
     * @param $name
     * @param $locality
     * @param $type
     * @return mixed|null
     */
    public function findByNameAndLocalityWithType($name, $locality, $type);
    /**
     * @param $page
     * @return \Zend\Paginator\Paginator $paginator
     */
    public function  fetchByPage($page);

    /**
     * @return array
     */
    public function fecthAll();

    /**
     * @param $id
     * @return Prestation|null
     */
    public function fetchByid($id);

    /**
     * @param $time
     * @param null $id
     * @return Prestation|null;
     */
    public function fetchByHoraire($time, $id = null);
    /**
     * @param \Prestation\Entity\AgeCategory[] $ageCategoryList
     * @param null $p_id
     * @return mixed
     */
    public function createRelWithAgeCategory($ageCategoryList, $p_id = null );

    /**
     * @param \Prestation\Entity\LevelCategory[] $levelCategory
     * @param null $p_id
     * @return mixed
     */
    public function createRelWithLevelCategory($levelCategory, $p_id = null);

    /**
     * @param \Prestation\Entity\Marker $marker
     * @param int $p_id
     * @return mixed
     */
    public function createRelWithMarker($marker, $p_id);

    /**
     * @param int $id
     * @return void
     */
    public function delete($id);
}
