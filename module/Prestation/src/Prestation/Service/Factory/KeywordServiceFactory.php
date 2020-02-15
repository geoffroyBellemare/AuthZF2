<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 18/05/2019
 * Time: 13:46
 */

namespace Prestation\Service\Factory;



use Prestation\Service\KeywordServiceImpl2;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class KeywordServiceFactory implements FactoryInterface
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
        $keywordRepo = $serviceLocator->get('Prestation\Repository\KeywordRepository');
        $aliasesRepo = $serviceLocator->get('Prestation\Repository\AliasesRepository');
        $service = new KeywordServiceImpl2($keywordRepo, $aliasesRepo);
        return $service;
    }
}