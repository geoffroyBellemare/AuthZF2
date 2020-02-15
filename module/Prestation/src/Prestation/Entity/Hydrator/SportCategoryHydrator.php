<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:45
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\SportCategory;
use Zend\Stdlib\Hydrator\HydratorInterface;

class SportCategoryHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof SportCategory) {
            return [
                'c_s_id' => $object->getId(),
                'c_s_name' => $object->getName(),
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
        if($object instanceof SportCategory) {
            $object->setId(isset($data['c_s_id'])? $data['c_s_id']: null);
            $object->setName(isset($data['c_s_name'])? $data['c_s_name']: null);
            $object->setKId( isset( $data['k_id'])? $data['k_id']: null );
        }

        return $object;
    }
}