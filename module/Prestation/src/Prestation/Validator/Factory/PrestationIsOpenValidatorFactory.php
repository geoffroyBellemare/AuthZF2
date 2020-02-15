<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/07/2019
 * Time: 14:52
 */

namespace Prestation\Validator\Factory;


use Prestation\Validator\PrestationIsOpenValidator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PrestationIsOpenValidatorFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $prestationRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\PrestationRepository');
        $reservationRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\ReservationRepository');
        $periodRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\PeriodRepository');
        $horaireRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\HoraireRepository');

        return new PrestationIsOpenValidator($prestationRepo, $reservationRepo, $periodRepo, $horaireRepo);
    }
}