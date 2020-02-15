<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/05/2019
 * Time: 17:46
 */

namespace Prestation\Validator\Factory;


use Prestation\Validator\HoraireValidator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HoraireValidatorFactory implements FactoryInterface
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
        $prestationRepo = $serviceLocator->getServicelocator()->get('Prestation\Repository\PrestationRepository');
        $prestataireService = $serviceLocator->getServicelocator()->get('Prestation\Service\PrestataireService');
        $validator = new HoraireValidator($prestationRepo, $prestataireService);
        return $validator;
    }
}