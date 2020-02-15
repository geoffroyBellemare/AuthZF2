<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 17:07
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Locality;
use Prestation\Entity\Prestation;
use Zend\Stdlib\Hydrator\HydratorInterface;

class LocalityHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Locality) {
            return [
                'l_id' => $object->getId(),
                'l_name' => $object->getName(),
                'l_postcode' => $object->getPostcode(),
                'k_id' =>$object->getKId()
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
        if($object instanceof Locality) {
            $object->setId(isset($data['l_id']) ? $data['l_id']: null);
            $object->setName(isset($data['l_name']) ? $data['l_name']: $data['l_name']);
            $object->setPostcode( isset($data['l_postcode'])? $data['l_postcode']: null );
            $object->setKId( isset($data['k_id'])? $data['k_id']: null );
        }

        if( $object instanceof Prestation) {
            $locality = new Locality();
            $locality->setId(isset($data['l_id']) ? $data['l_id'] : null);
            $locality->setPostcode(isset($data['l_postcode']) ? $data['l_postcode']: null);
            $locality->setName(isset($data['l_name']) ? $data['l_name'] : null);
            $locality->setKId(isset($data['l_k_id']) ? $data['l_k_id']: null);
            $object->getMarker()->setLocality($locality);
        }

        return $object;
    }
}