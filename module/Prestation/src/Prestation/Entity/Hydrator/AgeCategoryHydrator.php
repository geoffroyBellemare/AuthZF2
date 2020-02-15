<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 16:50
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\AgeCategory;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AgeCategoryHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof AgeCategory) {
            return [];
        }
        return [
           'c_a_id' => $object->getId(),
           'c_a_name' => $object->getName()
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
        if(!$object instanceof AgeCategory) {
            return $object;
        }

        $object->setId(isset( $data['c_a_id'])? $data['c_a_id'] : null);
        $object->setName(isset($data['c_a_name']) ? $data['c_a_name'] : null);

        return $object;
    }
}