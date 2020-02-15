<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:45
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Address;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AddressHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof Address) {
            return [];
        }

        $data = [
            'ad_id' => $object->getId(),
            'c_id' => $object->getCId(),
            'l_id' => $object->getLId(),
            'k_id' => $object->getKId(),
            'd_id' => $object->getDId(),
            'r_id' => $object->getRId()
        ];



        return $data;
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
        if($object instanceof Address) {

            $object->setId(isset($data['ad_id'])? $data['ad_id']: null);
            $object->setName(isset($data['ad_name'])? $data['ad_name']: null);
            $object->setCId(isset($data['c_id'])? $data['c_id']: null);
            $object->setLId(isset($data['l_id'])? $data['l_id']: null);
            $object->setDId(isset($data['d_id'])? $data['d_id']: null);
            $object->setRId(isset($data['r_id'])? $data['r_id']: null);
            $object->setKId(isset($data['k_id'])? $data['k_id']: null);


        }
        return $object;
    }
}