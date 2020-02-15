<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 26/05/2019
 * Time: 19:17
 */

namespace Prestation\Service\Factory;


use Prestation\Service\PeriodServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PeriodServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $perioRepo = $serviceLocator->get('Prestation\Repository\PeriodRepository');
        $horaireRepo = $serviceLocator->get('Prestation\Repository\HoraireRepository');
        $service = new PeriodServiceImpl($perioRepo, $horaireRepo);

        return $service;
    }
}