<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 26/05/2019
 * Time: 18:35
 */

namespace Prestation\Repository;


use Prestation\Entity\Period;

interface PeriodRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Period $period
     * @return int|null
     */
    public function save($period);

    /**
     * @param $data
     * @param null $p_id
     * @return mixed
     */
    public function findBy($data, $p_id = null);

    /**
     * @param $time
     * @param null $p_id
     * @return Period[]|mixed
     */
    public function findByDate($time, $p_id = null);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);
    /**
     * @param \Prestation\Entity\AgeCategory[] $ageCategoryList
     * @param null $pd_id
     * @return mixed
     */
    public function createRelWithAgeCategory($ageCategoryList, $pd_id = null );

    /**
     * @param \Prestation\Entity\LevelCategory[] $levelCategory
     * @param null $pd_id
     * @return mixed
     */
    public function createRelWithLevelCategory($levelCategory, $pd_id = null);

    /**
     * @param \Prestation\Entity\SubType[] $subTypes
     * @param int $pd_id
     */
    public function createRelWithSubType($subTypes, $pd_id);

    /**
     * @param $id
     * @return void
     */
    public function delete($id);

    /**
     * @param $p_id
     * @param $pd_id
     * @param $p_host_id
     * @param $p_host_price
     * @@return false|mixed
     */
    public function rent($p_id, $pd_id, $p_host_id, $p_host_price);
    //public function rent($p_id, $p_host_id, $pvr_id, $pd_id, $p_host_quantity, $p_host_price);
}