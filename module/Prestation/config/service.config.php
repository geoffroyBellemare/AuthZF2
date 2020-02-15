<?php
namespace Prestation;
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/09/2018
 * Time: 19:58
 */
use Prestation\Service\BackupService;
use Prestation\Service\BustFactorServiceImpl;
use Prestation\Service\CommodityServiceImpl;
use Prestation\Service\DepartementServiceImpl;
use Prestation\Service\KeywordServiceImpl;
use Prestation\Service\LocalityServiceImpl;
use Prestation\Service\MarkerServiceImpl;
use Prestation\Service\NamerServiceImpl;
use Prestation\Service\RegionServiceImpl;
use Prestation\Service\TypeServiceImpl;
use Zend\Form\Fieldset;

return array(
    'invokables'=> array(
        'Prestation\Repository\PrestationRepository' => 'Prestation\Repository\PrestationRepositoryImpl',
        'Prestation\Repository\keywordRepository' => 'Prestation\Repository\keywordRepositoryImpl',
        'Prestation\Repository\AliasesRepository' => 'Prestation\Repository\AliasesRepositoryImpl',
        'Prestation\Repository\CountryRepository' => 'Prestation\Repository\CountryRepositoryImpl',
        'Prestation\Repository\LocalityRepository' => 'Prestation\Repository\LocalityRepositoryImpl',
        'Prestation\Repository\MarkerRepository' => 'Prestation\Repository\MarkerRepositoryImpl',
        'Prestation\Repository\DepartementRepository' => 'Prestation\Repository\DepartementRepositoryImpl',
        'Prestation\Repository\RegionRepository' => 'Prestation\Repository\RegionRepositoryImpl',
        'Prestation\Repository\TypeRepository' => 'Prestation\Repository\TypeRepositoryImpl',
        'Prestation\Repository\SubTypeRepository' => 'Prestation\Repository\SubTypeRepositoryImpl',
        'Prestation\Repository\PeriodRepository' => 'Prestation\Repository\PeriodRepositoryImpl',
        'Prestation\Repository\LevelCategoryRepository' => 'Prestation\Repository\LevelCategoryRepositoryImpl',
        'Prestation\Repository\AgeCategoryRepository' => 'Prestation\Repository\AgeCategoryRepositoryImpl',
        'Prestation\Repository\HoraireRepository' => 'Prestation\Repository\HoraireRepositoryImpl',
        'Prestation\Repository\RentRepository' => 'Prestation\Repository\RentRepositoryImpl',
        'Prestation\Repository\SportsCategoryRepository' => 'Prestation\Repository\SportsCategoryRepositoryImpl',
        'Prestation\Repository\AddressRepository' => 'Prestation\Repository\AddressRepositoryImpl',
        'Prestation\Repository\CaptionRepository' => 'Prestation\Repository\CaptionRepositoryImpl',
        'Prestation\Repository\EntrepriseRepository' => 'Prestation\Repository\EntrepriseRepositoryImpl',
        'Prestation\Repository\VendreRepository' => 'Prestation\Repository\VendreRepositoryImpl',
        'Prestation\Repository\ReservationRepository' => 'Prestation\Repository\ReservationRepositoryImpl',
        'Prestation\Repository\PrestataireRepository' => 'Prestation\Repository\PrestataireRepositoryImpl',

    ),
    'factories' => array(
        'Prestation\Service\KeywordService' =>'Prestation\Service\Factory\KeywordServiceFactory',
        'Prestation\Service\CountryService' =>'Prestation\Service\Factory\CountryServiceFactory',
        'Prestation\Service\LocalityService' =>'Prestation\Service\Factory\LocalityServiceFactory',
        'Prestation\Service\MarkerService' =>'Prestation\Service\Factory\MarkerServiceFactory',
        'Prestation\Service\DepartementService' =>'Prestation\Service\Factory\DepartementServiceFactory',
        'Prestation\Service\TypeService' =>'Prestation\Service\Factory\TypeServiceFactory',
        'Prestation\Service\RegionService' =>'Prestation\Service\Factory\RegionServiceFactory',
        'Prestation\Service\SubTypeService' =>'Prestation\Service\Factory\SubTypeServiceFactory',
        'Prestation\Service\PeriodService' =>'Prestation\Service\Factory\PeriodServiceFactory',
        'Prestation\Service\AgeCategoryService' =>'Prestation\Service\Factory\AgeCategoryServiceFactory',
        'Prestation\Service\LevelCategoryService' =>'Prestation\Service\Factory\LevelCategoryServiceFactory',
        'Prestation\Service\HoraireService' =>'Prestation\Service\Factory\HoraireServiceFactory',
        'Prestation\Service\PrestataireService' =>'Prestation\Service\Factory\PrestataireServiceFactory',
        'Prestation\Service\RentService' =>'Prestation\Service\Factory\RentServiceFactory',
        'Prestation\Service\SportCategoryService' =>'Prestation\Service\Factory\SportCategoryServiceFactory',
        'Prestation\Service\AddressService' =>'Prestation\Service\Factory\AddressServiceFactory',
        'Prestation\Service\CaptionService' =>'Prestation\Service\Factory\CaptionServiceFactory',
        'Prestation\Service\VendreService' =>'Prestation\Service\Factory\VendreServiceFactory',
        'Prestation\Service\ReservationService' =>'Prestation\Service\Factory\ReservationServiceFactory',
        'Prestation\Service\PrestationService' =>'Prestation\Service\Factory\PrestationServiceFactory',


/*        'Prestation\Service\PrestationService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $serviceLocator->get('Prestation\Repository\KeywordRepository');
            $prestationService = new \Prestation\Service\PrestationServiceImpl();
            return $prestationService;
        },*/
    ),
    'initializers' => array(
        function($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
            }



        },
    ),
);