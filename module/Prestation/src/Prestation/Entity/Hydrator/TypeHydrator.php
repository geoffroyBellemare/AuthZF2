<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 15:44
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Prestation;
use Prestation\Entity\Type;
use Zend\Stdlib\Hydrator\HydratorInterface;

class TypeHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if( $object instanceof Type ) {
            return [
                't_id' => $object->getId(),
                't_name' => $object->getName(),
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
        if( $object instanceof Type ) {
            $object->setId(isset($data['t_id']) ? $data['t_id']: null);
            $object->setName( isset($data['t_name']) ? $data['t_name']: null);
            $object->setKId(isset($data['k_id'])? $data['k_id']: null);
        }

        if( $object instanceof Prestation) {
            $type = new Type();
            $type->setId(isset($data['t_id']) ? $data['t_id'] : null );
            $type->setName( isset( $data['t_name']) ? $data['t_name'] : null );
            $type->setKId(isset($data['t_k_id']) ? $data['t_k_id']: null);
            $object->setType($type);
        }


        return $object;
    }
}