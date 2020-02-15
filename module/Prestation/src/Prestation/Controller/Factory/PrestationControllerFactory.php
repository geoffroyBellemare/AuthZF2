<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/05/2019
 * Time: 16:05
 */

namespace Prestation\Controller\Factory;


use Prestation\Controller\PrestationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class PrestationControllerFactory implements  FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // TODO: Implement createService() method.

        $service =  $serviceLocator->getServicelocator()->get('Prestation\Service\PrestationService');
        $adapter =  $serviceLocator->getServicelocator()->get('Zend\Db\Adapter\Adapter');
        $horaireValidator = $serviceLocator->getServicelocator()->get('ValidatorManager')->get('Prestation\Validator\HoraireValidator');
        $reservationValidator = $serviceLocator->getServicelocator()->get('ValidatorManager')->get('Prestation\Validator\ReservationValidator');
        //$horaireValidator =  $serviceLocator->get('Prestation\Validator\HoraireValidator');

        $controller = new PrestationController($service, $horaireValidator, $reservationValidator, $adapter);
        return $controller;
    }
}