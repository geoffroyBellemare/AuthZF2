<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/06/2019
 * Time: 16:21
 */

namespace Prestation\Service;


class RentServiceImpl implements RentService
{
    /**
     * @var \Prestation\Repository\RentRepository
     */
    protected $rentRepo;

    /**
     * RentServiceImpl constructor.
     * @param \Prestation\Repository\RentRepository $rentRepo
     */
    public function __construct(\Prestation\Repository\RentRepository $rentRepo)
    {
        $this->rentRepo = $rentRepo;
    }


    /**
     * @param \Prestation\Entity\Prestation $prestation
     * @param \Prestation\Entity\Period $period
     * @param float $price
     * @@return false|mixed
     */
    public function save($prestation, $period, $price)
    {
        // TODO: Implement save() method.
        //SI LA PERIOD  EST DELOCALISER SUR AUTRE PRESTATION
        if($period->getPHostId()) {
            var_dump("deLocation d une autre prestation vers ->". $period->getPHostId());
        }

    }
}