<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/06/2019
 * Time: 18:24
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Caption;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CaptionHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof Caption) {
            return [];
        }

        $data = [
            'capt_id' => $object->getId(),
            'caption' => $object->getCaption(),
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
        if($object instanceof Caption) {
            $object->setId(isset($data['capt_id'])? $data['capt_id']: null);
            $object->setCaption(isset($data['caption'])? $data['caption']: null);
        }
        return $object;
    }
}