<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/07/2019
 * Time: 14:21
 */

namespace Reservation\Controller\Factory;


use Reservation\Controller\ReservationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReservationControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $prestationService =  $serviceLocator->getServicelocator()->get('Prestation\Service\PrestationService');
        $reservationService =  $serviceLocator->getServicelocator()->get('Prestation\Service\ReservationService');
        $prestationIsOpenValidator = $serviceLocator->getServicelocator()->get('ValidatorManager')->get('Prestation\Validator\PrestationIsOpenValidator');
        $controller = new ReservationController($prestationService, $reservationService, $prestationIsOpenValidator);

        return $controller;
    }
}