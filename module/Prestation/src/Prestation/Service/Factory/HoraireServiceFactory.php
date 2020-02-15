<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:37
 */

namespace Prestation\Service\Factory;


use Prestation\Service\HoraireServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HoraireServiceFactory implements FactoryInterface
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
        $horaireRepo = $serviceLocator->get('Prestation\Repository\HoraireRepository');
        $prestataireService = $serviceLocator->get('Prestation\Service\PrestataireService');
        $service = new HoraireServiceImpl($horaireRepo, $prestataireService);
        return $service;
    }
}