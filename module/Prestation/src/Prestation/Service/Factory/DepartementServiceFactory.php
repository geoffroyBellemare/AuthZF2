<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/05/2019
 * Time: 17:21
 */

namespace Prestation\Service\Factory;


use Prestation\Service\DepartementServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DepartementServiceFactory implements FactoryInterface
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
        $departmentRepo = $serviceLocator->get('Prestation\Repository\DepartementRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service = new DepartementServiceImpl($departmentRepo, $keywordRepo, $aliasesRepo);
        return $service;
    }
}