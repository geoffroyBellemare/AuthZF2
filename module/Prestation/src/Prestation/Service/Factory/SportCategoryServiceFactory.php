<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 13:10
 */

namespace Prestation\Service\Factory;


use Prestation\Service\SportCategoryServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SportCategoryServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sportsCategoryRepo = $serviceLocator->get('Prestation\Repository\SportsCategoryRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');
        $service = new SportCategoryServiceImpl($sportsCategoryRepo, $keywordRepo, $aliasesRepo);

        return $service;
    }
}