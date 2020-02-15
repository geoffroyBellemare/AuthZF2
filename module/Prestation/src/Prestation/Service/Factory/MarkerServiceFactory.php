<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/05/2019
 * Time: 13:37
 */

namespace Prestation\Service\Factory;


use Prestation\Service\MarkerServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MarkerServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $markerRepo = $serviceLocator->get('Prestation\Repository\MarkerRepository');
        $service = new MarkerServiceImpl($markerRepo);

        return $service;
    }
}