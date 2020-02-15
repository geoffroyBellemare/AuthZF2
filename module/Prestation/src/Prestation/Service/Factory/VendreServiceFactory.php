<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 03/07/2019
 * Time: 12:00
 */

namespace Prestation\Service\Factory;


use Prestation\Service\VendreServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VendreServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entrepriseRepo = $serviceLocator->get('Prestation\Repository\EntrepriseRepository');
        $vendreRepo = $serviceLocator->get('Prestation\Repository\VendreRepository');
        $reservationRepository = $serviceLocator->get('Prestation\Repository\ReservationRepository');

        $service = new VendreServiceImpl($vendreRepo, $entrepriseRepo);
        return $service;

    }
}