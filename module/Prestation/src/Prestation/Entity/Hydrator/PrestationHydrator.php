<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 03/09/2018
 * Time: 16:50
 */

namespace Prestation\Entity\Hydrator;

use Prestation\Entity\AgeCategory;
use Prestation\Entity\Aliases;
use Prestation\Entity\Country;
use Prestation\Entity\Departement;
use Prestation\Entity\Keyword;
use Prestation\Entity\LevelCategory;
use Prestation\Entity\Locality;
use Prestation\Entity\Marker;
use Prestation\Entity\Prestation;
use Prestation\Entity\Region;
use Prestation\Entity\SubType;
use Prestation\Entity\Type;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PrestationHydrator implements HydratorInterface
{

    public function extract($object) {
        if(!$object instanceof Prestation) {
            return Array();
        }

        return array(
            'name' => $object->getName(),
            'price' =>$object->getQuantity(),
            'k_id' => $object->getKId()
        );
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
        // TODO: Implement hydrate() method.
        if(!$object instanceof  Prestation) {
            return $object;
        }
        $object->setId(isset($data['p_id']) ? $data['p_id'] : null);
        $object->setName(isset($data['p_name']) ? $data['p_name'] : null);
        $object->setKId( isset($data['k_id'])? $data['k_id']: null );
        $object->setPrice( isset($data['p_price'])? $data['p_price'] : null);
        $object->setOwner( isset($data['p_owner'])? $data['p_owner'] : null);
        $object->setQuantity( isset($data['p_quantity']) ? $data['p_quantity'] : null);
        $object->setCreated( isset($data['p_created']) ? $data['p_created']: null);

        if (isset($data['age_categories'])) {
            $ageCategories = [];
            foreach ( explode(',', $data['age_categories']) as $key => $value) {
                list($c_a_id, $c_a_name) = explode(':', $value);
                $ageCategory = new AgeCategory();
                $ageCategory->setId($c_a_id);
                $ageCategory->setName($c_a_name);
                $ageCategories[] = $ageCategory;
            }
            if( count($ageCategories) > 0 )$object->setAgeCategory($ageCategories);
        }

        if (isset($data['level_categories'])) {
            $levelCategories = [];
            foreach (explode(',', $data['level_categories']) as $key => $value) {
                list($c_l_id, $c_l_name) = explode(':', $value);
                $levelCategory = new LevelCategory();
                $levelCategory->setId($c_l_id);
                $levelCategory->setName($c_l_name);
                $levelCategories[] = $levelCategory;
            }
            if( count($levelCategories) > 0 )$object->setLevelCategory($levelCategories);
        }

        if (isset($data['sub_types'])) {
            $subTypes = [];
            foreach (explode(',', $data['sub_types']) as $key => $value) {
                list($st_id, $st_name) = explode(':', $value);
                $subtype = new SubType();
                $subtype->setId($st_id);
                $subtype->setName($st_name);
                $subTypes[] = $subtype;
            }
            if( count($subTypes) > 0 )$object->setSubTypes($subTypes);
        }

/*        if( isset($data['m_id'])) {
            $marker = new Marker();
            $marker->setId($data['m_id']);
            $marker->setLat($data['lat']);
            $marker->setLng($data['lng']);

            $object->setMarker($marker);
        }*/
        /*
                $type = new Type();
                $type->setId(isset($data['t_id']) ? $data['t_id'] : null );
                $type->setName( isset( $data['t_name']) ? $data['t_name'] : null );
                $object->setType($type);

                if( isset($data['lat']) && isset( $data['lng']) ) {

                    $locality = new Locality();
                    $locality->setId( isset( $data['l_id'])? $data['l_id']: null);
                    $locality->setName( isset($data['l_name']) ? $data['l_name']: null);
                    $locality->setPostcode( isset($data['l_postcode'])? $data['l_postcode']: null);


                    $country = new Country();
                    $country->setId(isset($data['c_id']) ? $data['c_id'] : null);
                    $country->setName( isset($data['c_name']) ? $data['c_name']: null );
                    $country->setCode(isset($data['c_code']) ? $data['c_code']: null);

                    $department = null;
                    if( isset($data['d_id']) ) {
                        $department = new Departement();
                        $department->setId(isset($data['d_id']) ? $data['d_id']: null);
                        $department->setName(isset($data['d_name']) ? $data['d_name']: null);
                    }

                    $region = null;
                    if( isset($data['r_id']) ) {
                        $region = new Region();
                        $region->setId(isset($data['r_id']) ? $data['r_id']: null);
                        $region->setName(isset($data['r_name']) ? $data['r_name']: null);
                    }

                    $marker = new Marker();
                    $marker->setId($data['m_id']);
                    $marker->setLat($data['lat']);
                    $marker->setLng($data['lng']);
                    $marker->setLocality($locality);
                    $marker->setDepartement($department);
                    $marker->setRegion($region);
                    $marker->setCountry($country);
                    $object->setMarker($marker);
                }*/

        return $object;
    }
}