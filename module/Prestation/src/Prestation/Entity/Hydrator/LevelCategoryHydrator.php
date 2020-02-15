<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/10/2018
 * Time: 11:56
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\LevelCategory;
use Zend\Stdlib\Hydrator\HydratorInterface;

class LevelCategoryHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof LevelCategory) {
            return [];
        }
        return [
            'c_l_id' => $object->getId(),

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
        if(!$object instanceof LevelCategory) {
            return $object;
        }

        $object->setId( isset( $data['c_l_id'])? $data['c_l_id']: null );
        $object->setName( isset($data['c_l_name']) ? $data['c_l_name'] : null);

        return $object;
    }
}