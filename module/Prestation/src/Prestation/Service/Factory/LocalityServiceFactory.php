<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/05/2019
 * Time: 12:58
 */

namespace Prestation\Service\Factory;


use Prestation\Service\LocalityServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocalityServiceFactory implements FactoryInterface
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
        $localityRepo = $serviceLocator->get('Prestation\Repository\LocalityRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service  = new LocalityServiceImpl($localityRepo, $keywordRepo, $aliasesRepo);
        return $service;
    }
}