<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/05/2019
 * Time: 15:24
 */

namespace Prestation\Service\Factory;


use Prestation\Service\AgeCategoryServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AgeCategoryServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ageCategoryRepo = $serviceLocator->get('Prestation\Repository\AgeCategoryRepository');
        $service = new AgeCategoryServiceImpl($ageCategoryRepo);

        return $service;
    }
}