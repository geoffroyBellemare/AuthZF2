<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/11/2018
 * Time: 22:01
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\BustFactor;
use Zend\Stdlib\Hydrator\HydratorInterface;

class BustFactorHydrator implements  HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
       if(!$object instanceof BustFactor) {
           return [];
       }

       return [
           'bf_id' => $object->getId(),
           'bf_name' => $object->getName()
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
        if(!$object instanceof BustFactor) {
            return $object;
        }
        $object->setId( isset($data['bf_id']) ? $data['bf_id'] : null);
        $object->setName( isset($data['bf_name']) ? $data['bf_name'] : null);

        return $object;
    }
}