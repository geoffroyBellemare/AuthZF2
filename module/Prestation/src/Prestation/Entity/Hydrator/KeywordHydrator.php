<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 15:48
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Keyword;
use Prestation\Entity\Prestation;
use Zend\Stdlib\Hydrator\HydratorInterface;

class KeywordHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Keyword) {
            return [
                'k_id' => $object->getId(),
                'k_name' => $object->getName()
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
        if($object instanceof Keyword) {
            $object->setId(isset($data['k_id']) ? $data['k_id']: null);
            $object->setName( isset($data['k_name']) ? $data['k_name']: null);

            return $object;
        }
        if( $object instanceof Prestation) {
            $keyword = new Keyword();
            $keyword->setId($data['p_k_id']);
            $keyword->setName($data['k_name']);
            $object->setKeyword($keyword);

            return $object;
        }


        return $object;
    }
}