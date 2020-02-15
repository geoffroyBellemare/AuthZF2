<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:45
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Country;
use Prestation\Entity\Departement;
use Prestation\Entity\Locality;
use Prestation\Entity\Marker;
use Prestation\Entity\Prestation;
use Prestation\Entity\Region;
use Zend\Stdlib\Hydrator\HydratorInterface;

class MarkerHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof Marker) {
            return [];
        }
        return [
            'm_id' => $object->getId(),
        ];
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if($object instanceof Marker) {

            $object->setId(isset($data['m_id'])? $data['m_id']: null);
            $object->setLat( isset($data['lat']) ? $data['lat']: null);
            $object->setLng( isset($data['lng']) ? $data['lng'] : null);

            $locality = new Locality();
            $locality->setId($data['l_id']);
            $locality->setName($data['l_name']);
            $locality->setPostcode($data['l_postcode']);

            $object->setLocality($locality);

            $country = new Country();
            $country->setId($data['c_id']);
            $country->setName($data['c_name']);
            $country->setCode($data['c_code']);

            $object->setCountry($country);

            if( isset($data['d_id']) && isset($data['d_name']) ) {

                $departement = new Departement();
                $departement->setId($data['d_id']);
                $departement->setName($data['d_name']);
                $object->setDepartement($departement);
            }
            if( isset($data['r_id']) && isset($data['r_name']) ) {
                $region = new Region();
                $region->setId($data['r_id']);
                $region->setName($data['r_name']);

                $object->setRegion($region);

            }
        }
        if($object instanceof Prestation) {
            if( isset($data['markers']) ) {
                $markersList = explode(",", $data['markers'] );
                $markers = array_map( function($markerString) {
                    $markerAttributes = explode(":", $markerString);
                    $countryString = $markerAttributes[3];
                    $localityString = $markerAttributes[4];

                    $countryAttributes = explode("#", $countryString );
                    $localityAttributes = explode("#", $localityString);

                    $country = new Country();
                    $country->setId($countryAttributes[0]);
                    $country->setName($countryAttributes[1]);
                    $country->setCode($countryAttributes[2]);

                    $locality = new Locality();
                    $locality->setId($localityAttributes[0]);
                    $locality->setName($localityAttributes[1]);
                    $locality->setPostcode($localityAttributes[2]);

                    $marker = new Marker();
                    $marker->setId($markerAttributes[0]);
                    $marker->setLat($markerAttributes[1]);
                    $marker->setLng($markerAttributes[2]);
                    $marker->setLocality($locality);
                    $marker->setCountry($country);

                    return $marker;
                }, $markersList);
                $object->setMarkers(count($markers) > 0 ? $markers : null);
            }
        }
        return $object;
    }
}