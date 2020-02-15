<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 18/05/2019
 * Time: 13:38
 */

namespace Prestation\Service\Factory;


use Prestation\Service\PrestationServiceImpl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PrestationServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $countryService = $serviceLocator->get('Prestation\Service\CountryService');
        $localityService = $serviceLocator->get('Prestation\Service\LocalityService');
        $markerService = $serviceLocator->get('Prestation\Service\MarkerService');
        $departementService = $serviceLocator->get('Prestation\Service\DepartementService');
        $typeService = $serviceLocator->get('Prestation\Service\TypeService');
        $regionService = $serviceLocator->get('Prestation\Service\RegionService');
        $subTypeService = $serviceLocator->get('Prestation\Service\SubTypeService');
        $keywordService = $serviceLocator->get('Prestation\Service\KeywordService');
        $periodService = $serviceLocator->get('Prestation\Service\PeriodService');
        $ageCategoryService = $serviceLocator->get('Prestation\Service\AgeCategoryService');
        $levelCategory = $serviceLocator->get('Prestation\Service\LevelCategoryService');
        $horaireService = $serviceLocator->get('Prestation\Service\HoraireService');
        $prestataireService = $serviceLocator->get('Prestation\Service\PrestataireService');
        $rentService = $serviceLocator->get('Prestation\Service\RentService');
        $sportCategoryService = $serviceLocator->get('Prestation\Service\SportCategoryService');
        $addressService = $serviceLocator->get('Prestation\Service\AddressService');
        $captionService = $serviceLocator->get('Prestation\Service\CaptionService');
        $vendreService = $serviceLocator->get('Prestation\Service\VendreService');
        $reservationService = $serviceLocator->get('Prestation\Service\ReservationService');
        $prestationrepo = $serviceLocator->get('Prestation\Repository\PrestationRepository');

        $service = new PrestationServiceImpl(
                                                $countryService,
                                                $localityService,
                                                $markerService,
                                                $departementService,
                                                $typeService,
                                                $subTypeService,
                                                $regionService,
                                                $keywordService,
                                                $periodService,
                                                $ageCategoryService,
                                                $levelCategory,
                                                $horaireService,
                                                $prestataireService,
                                                $rentService,
                                                $sportCategoryService,
                                                $addressService,
                                                $captionService,
                                                $vendreService,
                                                $reservationService,
                                                $prestationrepo
                                            );
        return $service;
    }
}