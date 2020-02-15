<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/05/2019
 * Time: 16:39
 */

namespace Prestation\Service\Factory;


use Prestation\Service\LevelCategoryServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LevelCategoryServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $levelrepo = $serviceLocator->get('Prestation\Repository\LevelCategoryRepository');
        $service = new LevelCategoryServiceImpl($levelrepo);
        return $service;
    }
}