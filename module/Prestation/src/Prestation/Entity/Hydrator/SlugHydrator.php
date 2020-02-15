<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 03/09/2018
 * Time: 16:50
 */

namespace Prestation\Entity\Hydrator;

use Prestation\Entity\Slug;
use Zend\Stdlib\Hydrator\HydratorInterface;

class SlugHydrator implements HydratorInterface
{

    public function extract($object) {
        if(!$object instanceof Slug) {
            return Array();
        }

        return array(
            's_name' => $object->getName()
        );
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
        // TODO: Implement hydrate() method.
        if(!$object instanceof  Slug) {
            return $object;
        }
        $object->setId(isset($data['s_id']) ? $data['s_id'] : null);
        $object->setName(isset($data['s_name']) ? $data['s_name'] : null);
        return $object;
    }
}