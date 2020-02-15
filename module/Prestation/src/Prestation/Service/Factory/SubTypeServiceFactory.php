<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 25/05/2019
 * Time: 20:01
 */

namespace Prestation\Service\Factory;


use Prestation\Service\SubTypeServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubTypeServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subTypeRepo = $serviceLocator->get('Prestation\Repository\SubTypeRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service = new SubTypeServiceImpl($subTypeRepo, $keywordRepo, $aliasesRepo);

        return $service;
    }
}