<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 08/11/2018
 * Time: 15:57
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Commodity;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CommodityHydrator implements  HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof  Commodity) {
            return [];
        }
        return [
            'cmd_id' => $object->getId(),
            'cmd_name' => $object->getName(),
            'k_id' => $object->getKId(),
            'cmd_note' =>$object->getNote(),
            'cmd_description' => $object->getDescription()
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
        if(!$object instanceof  Commodity ) {
            return $object;
        }

        $object->setId(isset($data['cmd_id']) ? $data['cmd_id'] : null);
        $object->setName(isset($data['cmd_name']) ? $data['cmd_name'] : null);
        $object->setKId( isset( $data['k_id']) ? $data['k_id'] : null);
        $object->setNote( isset( $data['cmd_note']) ? $data['cmd_note']: null);
        $object->setDescription( isset($data['cmd_description']) ? $data['cmd_description']: null);

        return $object;
    }
}