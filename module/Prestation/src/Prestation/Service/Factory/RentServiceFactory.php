<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/06/2019
 * Time: 16:25
 */

namespace Prestation\Service\Factory;


use Prestation\Service\RentServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RentServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $rentRepo = $serviceLocator->get('Prestation\Repository\RentRepository');
        $service = new RentServiceImpl($rentRepo);
        return $service;
    }
}