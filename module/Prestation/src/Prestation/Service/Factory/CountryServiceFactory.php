<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 18/05/2019
 * Time: 19:59
 */

namespace Prestation\Service\Factory;


use Prestation\Service\CountryServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CountryServiceFactory implements FactoryInterface
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
        //$keywordService = $serviceLocator->get('Prestation\Service\KeywordService');
        $countryRepo = $serviceLocator->get('Prestation\Repository\CountryRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service = new CountryServiceImpl($countryRepo, $keywordRepo, $aliasesRepo);
        return $service;
    }
}