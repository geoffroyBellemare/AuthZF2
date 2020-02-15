<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 15:32
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Country;
use Prestation\Entity\Prestation;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CountryHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Country ) {
            return [
                'c_id'=> $object->getId(),
                'c_name' => $object->getName(),
                'c_code' => $object->getCode(),
                'k_id' => $object->getKId()
            ];
        }

        return [];
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
        if($object instanceof Country){
            $object->setId(isset($data['c_id'])? $data['c_id']: null);
            $object->setName(isset($data['c_name'])? $data['c_name']: null);
            $object->setCode(isset($data['c_code'])? $data['c_code']: null);
            $object->setKId(isset($data['k_id'])? $data['k_id']: null);
        }

        if($object instanceof Prestation ) {
            $country = new Country();
            $country->setId(isset($data['c_id'])? $data['c_id']: null);
            $country->setName(isset($data['c_name'])? $data['c_name']: null);
            $country->setCode(isset($data['c_code'])? $data['c_code']: null);
            $country->setKId(isset($data['c_k_id'])? $data['c_k_id']: null);
            $object->getMarker()->setCountry($country);
        }


        return $object;

    }
}