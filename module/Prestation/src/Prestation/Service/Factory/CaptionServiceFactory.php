<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/06/2019
 * Time: 14:28
 */

namespace Prestation\Service\Factory;


use Prestation\Service\CaptionServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CaptionServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $captionRepo = $serviceLocator->get('Prestation\Repository\CaptionRepository');
        $service = new CaptionServiceImpl($captionRepo);
        return $service;
    }
}