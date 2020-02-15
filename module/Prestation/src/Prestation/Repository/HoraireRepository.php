<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:26
 */

namespace Prestation\Repository;


use Prestation\Entity\Period;

interface HoraireRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Horaire $horaire
     * @return mixed
     */
    public function save($horaire);

    /**
     * @param $data
     * @return mixed|null
     */
    public function findBy($data);

    /**
     * @param $time
     * @param $pd_id
     * @return mixed
     */
    public function findByTime($time, $pd_id);
}