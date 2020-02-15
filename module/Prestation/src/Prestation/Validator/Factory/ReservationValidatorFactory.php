<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/07/2019
 * Time: 11:18
 */

namespace Prestation\Validator\Factory;


use Prestation\Validator\ReservationValidator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReservationValidatorFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $reservationService = $serviceLocator->getServicelocator()->get('Prestation\Service\ReservationService');
        $prestationRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\PrestationRepository');
        $validator = new ReservationValidator($reservationService);
        return $validator;
    }
}