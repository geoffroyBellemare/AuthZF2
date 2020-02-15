<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 23:54
 */

namespace Prestation\Service;


use Prestation\Entity\Country;
use Prestation\Entity\Departement;
use Prestation\Entity\Locality;
use Prestation\Entity\Marker;
use Prestation\Entity\Region;

class MarkerServiceImpl implements MarkerService
{
    /**
     * @var \Prestation\Repository\MarkerRepository
     */
    public $markerRepository;
    /**
     * @var \Prestation\Repository\LocalityRepository
     */
    public $localityRepository;
    /**
     * @var \Prestation\Repository\DepartementRepository
     */
    public $departementRepository;
    /**
     * @var \Prestation\Repository\RegionRepository
     */
    public $regionRepository;
    /**
     * @var \Prestation\Repository\CountryRepository
     */
    public $countryRepository;

    /**
     * MarkerServiceImpl constructor.
     * @param \Prestation\Repository\MarkerRepository $markerRepository
     * @param \Prestation\Repository\LocalityRepository $localityRepository
     * @param \Prestation\Repository\DepartementRepository $departementRepository
     * @param \Prestation\Repository\RegionRepository $regionRepository
     * @param \Prestation\Repository\CountryRepository $countryRepository
     */
    public function __construct(\Prestation\Repository\MarkerRepository $markerRepository, \Prestation\Repository\LocalityRepository $localityRepository, \Prestation\Repository\DepartementRepository $departementRepository, \Prestation\Repository\RegionRepository $regionRepository, \Prestation\Repository\CountryRepository $countryRepository)
    {
        $this->markerRepository = $markerRepository;
        $this->localityRepository = $localityRepository;
        $this->departementRepository = $departementRepository;
        $this->regionRepository = $regionRepository;
        $this->countryRepository = $countryRepository;
    }

    public function save($data) {
        $country = $this->countryRepository->findByName($data['country']);
        if (!$country) {
            $country = new Country();
            $country->setName($data['country']);
            $country->setCode($data['country_code']);
            $country->setId($this->countryRepository->create($country));
        }

        $region = $this->regionRepository->findByName($data['region']);
        if( !$region ) {
            $region = new Region();
            $region->setName($data['region']);
            $region->setId($this->regionRepository->create($region));
        }

        $departement = $this->departementRepository->findByName($data['departement']);
        if(!$departement) {
            $departement = new Departement();
            $departement->setName($data['departement']);
            $departement->setId($this->departementRepository->create($departement));
        }

        $locality = $this->localityRepository->findByName($data['locality']);
        if(!$locality) {
            $locality = new Locality();
            $locality->setName($data['locality']);
            $locality->setPostcode($data['postcode']);
            $locality->setId($this->localityRepository->create($locality));
        }

        $marker = new Marker();
        $marker->setLat((float)$data['lat']);
        $marker->setLng($data['lng']);
        $marker->setDepartement($departement);
        $marker->setRegion($region);
        $marker->setLocality($locality);
        $marker->setCountry($country);

        $markerRecorded = $this->markerRepository->findBy($marker);

        if( !$markerRecorded ) {
            $marker->setId($this->markerRepository->create($marker));
            $this->departementRepository->createRelation($marker->getDepartement(), $marker);
            $this->regionRepository->createRelation($marker->getRegion(), $marker);
        } else {
            $marker = $markerRecorded;
        }

        return $marker;
    }

    /**
     * @param \Prestation\Entity\Marker|null
     */
    public function saveFromBackup ($data, $country, $locality) {

        $marker = $this->markerRepository->findBy($data['lat'], $data['lng']);
        if( !$marker ) {
            $marker = new Marker();
            $marker->setLat((float)$data['lat']);
            $marker->setLng($data['lng']);
            $marker->setCountry($country);
            $marker->setLocality($locality);
            $marker->setId($this->markerRepository->create($marker));
        }

/*
        if( !$marker->getId() ) {
            $marker = $this->markerRepository->findBy($marker);
        }*/
        return $marker;
    }
}