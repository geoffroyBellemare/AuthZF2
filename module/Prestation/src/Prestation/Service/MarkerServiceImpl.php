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


    public function __construct(\Prestation\Repository\MarkerRepository $markerRepository)
    {
        $this->markerRepository = $markerRepository;

    }

    public function save ($data, $country, $locality, $department = null, $region = null) {

       $marker = $this->markerRepository->findBy($data['lat'], $data['lng']);
        if( !$marker ) {
            $marker = new Marker();
            $marker->setLat($data['lat']);
            $marker->setLng($data['lng']);
            $marker->setCountry($country);
            $marker->setLocality($locality);
            if($department) $marker->setDepartement($department);
            if($region) $marker->setRegion($region);
            $marker->setId($this->markerRepository->create($marker));
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