<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/05/2019
 * Time: 18:05
 */

namespace Prestation\Service\Factory;


use Prestation\Service\RegionServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegionServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $regionRepo = $serviceLocator->get('Prestation\Repository\RegionRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service = new RegionServiceImpl($regionRepo, $keywordRepo, $aliasesRepo);
        return $service;
    }
}