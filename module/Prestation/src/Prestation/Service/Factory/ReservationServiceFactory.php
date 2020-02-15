<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/07/2019
 * Time: 22:52
 */

namespace Prestation\Service\Factory;


use Prestation\Service\ReservationServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReservationServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $reservationRepo = $serviceLocator->get('Prestation\Repository\ReservationRepository');
        $prestationRepo = $serviceLocator->get('Prestation\Repository\PrestationRepository');
        $service = new ReservationServiceImpl($reservationRepo, $prestationRepo);
        return $service;
    }
}