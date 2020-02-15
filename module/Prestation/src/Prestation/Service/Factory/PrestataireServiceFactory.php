<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 20:48
 */

namespace Prestation\Service\Factory;


use Prestation\Service\PrestataireServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PrestataireServiceFactory implements FactoryInterface
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
        $prestataireRepo = $serviceLocator->get('Prestation\Repository\PrestataireRepository');
        $service = new PrestataireServiceImpl($prestataireRepo);
        return $service;
    }
}