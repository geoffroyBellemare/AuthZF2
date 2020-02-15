<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/05/2019
 * Time: 17:47
 */

namespace Prestation\Service\Factory;


use Prestation\Service\TypeServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TypeServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $typeRepo = $serviceLocator->get('Prestation\Repository\TypeRepository');
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');

        $service = new TypeServiceImpl($typeRepo, $keywordRepo, $aliasesRepo);

        return $service;
    }
}