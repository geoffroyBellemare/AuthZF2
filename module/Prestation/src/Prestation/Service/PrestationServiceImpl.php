<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/05/2019
 * Time: 15:41
 */

namespace Prestation\Service;


use Prestation\Entity\Entreprise;
use Prestation\Entity\Horaire;
use Prestation\Entity\Period;
use Prestation\Entity\Prestation;
use Prestation\Entity\User;
use Prestation\Repository\PrestationRepository;
use Prestation\Utils\DateManipulation;

class PrestationServiceImpl implements PrestationService
{

    /**
     * @var \Prestation\Service\CountryService
     */
    protected $countryService;
    /**
     * @var \Prestation\Service\LocalityService
     */
    protected $localityService;
    /**
     * @var \Prestation\Service\MarkerService
     */
    protected $markerService;
    /**
     * @var \Prestation\Service\DepartementService
     */
    protected $departementService;
    /**
     * @var \Prestation\Service\RegionService
     */
    protected $regionService;
    /**
     * @var \Prestation\Service\TypeService
     */
    protected $typeService;
    /**
     * @var \Prestation\Service\SubTypeService
     */
    protected $subTypeService;
    /**
     * @var \Prestation\Service\KeywordServiceImpl2
     */
    protected $keywordService;
    /**
     * @var \Prestation\Service\PeriodService
     */
    protected $periodService;
    /**
     * @var \Prestation\Service\AgeCategoryService
     */
    protected $ageCategoryService;
    /**
     * @var \Prestation\Service\LevelCategoryService
     */
    protected $levelCategoryService;
    /**
     * @var \Prestation\Service\HoraireService
     */
    protected $horaireService;
    /**
     * @var \Prestation\Service\PrestataireService
     */
    protected $prestataireService;
    /**
     * @var \Prestation\Service\RentService
     */
    protected $rentService;
    /**
     * @var \Prestation\Service\SportCategoryServiceImpl
     */
    protected $sportCategoryService;
    /**
     * @var \Prestation\Service\AddressServiceImpl
     */
    protected $addressService;
    /**
     * @var \Prestation\Service\CaptionService
     */
    protected $captionService;
    /**
     * @var \Prestation\Service\VendreService
     */
    protected $vendreService;
    /**
     * @var \Prestation\Service\ReservationService
     */
    protected $reservationService;
    /**
     * @var \Prestation\Repository\PrestationRepository
     */
    public $prestationRepo;



    /**
     * PrestationServiceImpl constructor.
     * @param CountryService $countryService
     * @param LocalityService $localityService
     * @param MarkerService $markerService
     * @param DepartementService $departementService
     * @param RegionService $regionService
     * @param TypeService $typeService
     * @param KeywordServiceImpl2 $typeService
     * @param PrestationRepository $prestationRepo
     *
     */
    public function __construct(CountryService $countryService, LocalityService $localityService, MarkerService $markerService, DepartementService $departementService, TypeService $typeService, $subTypeService, RegionService $regionService, KeywordServiceImpl2 $keywordService, PeriodService $periodService, AgeCategoryService $ageCategoryService, LevelCategoryService $levelCategoryService, HoraireService $horaireService, PrestataireService $prestataireService, RentService $rentService, SportCategoryServiceImpl $sportCategoryService, AddressServiceImpl $addressService, CaptionService $captionService, VendreService $vendreService, ReservationService $reservationService, PrestationRepository $prestationRepo)
    {
        $this->countryService = $countryService;
        $this->localityService = $localityService;
        $this->markerService = $markerService;
        $this->departementService = $departementService;
        $this->regionService = $regionService;
        $this->typeService = $typeService;
        $this->subTypeService = $subTypeService;
        $this->keywordService = $keywordService;
        $this->periodService = $periodService;
        $this->ageCategoryService = $ageCategoryService;
        $this->levelCategoryService = $levelCategoryService;
        $this->horaireService = $horaireService;
        $this->prestataireService = $prestataireService;
        $this->sportCategoryService = $sportCategoryService;
        $this->addressService = $addressService;
        $this->captionService = $captionService;
        $this->vendreService = $vendreService;
        $this->reservationService = $reservationService;
        $this->rentService = $rentService;
        $this->prestationRepo = $prestationRepo;
    }


    public function create($data){

        //$typeArgs = ['type' => 'spots', 'aliases' => ['spot'] ];

        $country = $this->countryService->save($data);
        $locality = $this->localityService->save($data);
        $department = $this->departementService->save($data);
        $region = $this->regionService->save($data);
        $marker  =  $this->markerService->save($data, $country, $locality, $department, $region);
        $type = $this->typeService->save($data['type']);
        $subTypes = $this->subTypeService->save($data);
        $ageCategories = $this->ageCategoryService->save($data);
        $levelCategories = $this->levelCategoryService->save($data);
        $sportCategories = $this->sportCategoryService->save($data);
        $address = $this->addressService->save($data, $locality->getId(), $country->getId(), ($department) ? $department->getId(): null, ($region) ? $region->getId(): null);
        $caption = $this->captionService->save($data);

        $keyword = $this->keywordService->saveKeyword(7, $data['name'], []);

        $prestation = $this->prestationRepo->findByNameAndLocalityWithType(
            $data['name'],
            $marker->getLocality()->getName(),
            $type->getId()
        );

        $user = new User();
        $user->setUserId(1);
        $user->setEmail('etetetet');
        $user->setUserName('hfhfhfhfhf');

        if (!$prestation) {
            $prestation = new Prestation();
            $prestation->setKId($keyword->getId());
            $prestation->setName($data['name']);
            $prestation->setQuantity($data['quantity']);
            $prestation->setPrice($data['price']);
            $prestation->setOwner($data['owner']);
            $prestation->setType($type);
            $prestation->setMarker($marker);
            $prestation->setSubTypes($subTypes);
            $prestation->setAgeCategory($ageCategories);
            $prestation->setSportCategory($sportCategories);
            $prestation->setLevelCategory($levelCategories);
            $prestation->setAddress($address);
            $prestation->setCaption($caption);
            $prestation->setUser($user);
            $prestation->setId($this->prestationRepo->create2($prestation));
        }

        if(!isset($data['periods'])) $data['periods'] = DateManipulation::getInfinitePeriod();
        $this->reservationService->create($data, $user);
       $period = $this->periodService->save($data,$prestation, $subTypes, $ageCategories, $levelCategories);
        /*      $user = new Entreprise();
             $user->setUserId(1);
             $user->setName('slideguide');
             $user->setEmail('etetetet');
             $user->setUserName('dddddd');
             $this->vendreService->create($user, $prestation, $prestation, $period[0]);*/
        return $prestation;
/*        return [
            $country,
            $locality,
            $region,
            $department,
            $marker,
            $type,
            $sportCategories,
            $address,
            $caption
        ];*/
       // $country = $this->countryService->save($data);
        //$locality = $this->localityService->save($data);
    }
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function save($data)
    {


       $typeArgs = ['type' => 'cours', 'aliases' => ['lecon'] ];

        $country = $this->countryService->save($data);
        $locality = $this->localityService->save($data);
        $marker = $this->markerService->save($data, $country, $locality);
        $type = $this->typeService->save($typeArgs);
        $subTypes = $this->subTypeService->save($data);
        $ageCategories = $this->ageCategoryService->save($data);
        $levelCategories = $this->levelCategoryService->save($data);
        $this->departementService->save($data, $marker);
        $this->regionService->save($data, $marker);

        $keyword = $this->keywordService->saveKeyword(7, $data['name'], []);

        $prestation = $this->prestationRepo->findByNameAndLocalityWithType(
            $data['name'],
            $marker->getLocality()->getName(),
            $type->getId()
        );

        if( !$prestation ) {

            $prestation = new Prestation();
            $prestation->setKId($keyword->getId());
            $prestation->setName($data['name']);
            $prestation->setQuantity($data['quantity']);
            $prestation->setPrice($data['price']);
            $prestation->setOwner($data['owner']);
            $prestation->setType($type);
            $prestation->setMarker($marker);
            $prestation->setSubTypes($subTypes);
            $prestation->setAgeCategory($ageCategories);
            $prestation->setLevelCategory($levelCategories);
            $prestation->setId($this->prestationRepo->create2($prestation));

        }
        //return $prestation;
        //var_dump($prestation);
        $id = $prestation->getId();

        //always need a period
        if(!isset($data['periods'])) $data['periods'] = DateManipulation::getInfinitePeriod();

        if ( isset($id)) {


           // $period = $this->periodService->save($data, $prestation, $subTypes, $ageCategories, $levelCategories);

            //$this->rentService->save($prestation, $period, 15);

            //TODO Warning must check if the provider isn t elsewhere
            //or already work for that date
            // before register or choose another provider
            // $

            //$this->horaireService->save($data, $period->getPdId());

        }


        return isset($id)?$prestation:null;
    }
    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public function update(Prestation $prestation)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page)
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        // TODO: Implement fetchAll() method.
    }

    /**
     * @param $id
     * @return Prestation|null
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        //TODO Warning periodservice should implement own delete
        //$this->periodService->delete($id);
        //recuperer ttes les period appartenant a  cette prestation
        //
        $this->prestationRepo->delete($id);

    }

    /**
     * @param $data
     * @return mixed
     */
    public function isFree($data)
    {
        $this->prestationRepo->isFree($data);
/*        $prestation = new Prestation();
        $prestation->setId($p_id);
        $horaire = new Horaire();
        $horaire->setHStart(DateManipulation::convertDateStringToTime($dates['start']));
        $horaire->setHEnd(DateManipulation::convertDateStringToTime($dates['end']));
        $period = new Period();
        $period->setPdStart(DateManipulation::convertDateStringToDate($dates['start']));
        $period->setPdEnd(DateManipulation::convertDateStringToDate($dates['start']));*/
        //$this->prestationRepo->isFree($prestation, $period, $horaire);
    }



    /**
     * @param $data
     * @return mixed
     */
    public function share($data)
    {
        // TODO: Implement share() method.
        $typeArgs = ['type' => 'cours', 'aliases' => ['lecon'] ];

        $country = $this->countryService->save($data);
        $locality = $this->localityService->save($data);
        $department = $this->departementService->save($data);
        $region = $this->regionService->save($data);
        $marker  =  $this->markerService->save($data, $country, $locality, $department, $region);
        $type = $this->typeService->save($typeArgs);
        $subTypes = $this->subTypeService->save($data);
        $ageCategories = $this->ageCategoryService->save($data);
        $levelCategories = $this->levelCategoryService->save($data);
        $sportCategories = $this->sportCategoryService->save($data);
        $address = $this->addressService->save($data, $locality->getId(), $country->getId(), ($department) ? $department->getId(): null, ($region) ? $region->getId(): null);
        $caption = $this->captionService->save($data);

        $keyword = $this->keywordService->saveKeyword(7, $data['name'], []);

        $prestation = $this->prestationRepo->findByNameAndLocalityWithType(
            $data['name'],
            $marker->getLocality()->getName(),
            $type->getId()
        );

        $user = new User();
        $user->setUserId(1);
        $user->setEmail('etetetet');
        $user->setUserName('hfhfhfhfhf');

        if (!$prestation) {
            $prestation = new Prestation();
            $prestation->setKId($keyword->getId());
            $prestation->setName($data['name']);
            $prestation->setQuantity($data['quantity']);
            $prestation->setPrice($data['price']);
            $prestation->setOwner($data['owner']);
            $prestation->setType($type);
            $prestation->setMarker($marker);
            $prestation->setSubTypes($subTypes);
            $prestation->setAgeCategory($ageCategories);
            $prestation->setSportCategory($sportCategories);
            $prestation->setLevelCategory($levelCategories);
            $prestation->setAddress($address);
            $prestation->setCaption($caption);
            $prestation->setUser($user);
            $prestation->setId($this->prestationRepo->create2($prestation));
        }
        if(!isset($data['periods'])) $data['periods'] = DateManipulation::getInfinitePeriod();

        $period = $this->periodService->save($data,$prestation, $subTypes, $ageCategories, $levelCategories);


        return $prestation;
    }
}