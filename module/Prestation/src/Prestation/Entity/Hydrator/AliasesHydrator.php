<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 17:28
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Aliases;
use Prestation\Entity\Prestation;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AliasesHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Aliases) {
            return [
                'a_id' => $object->getId(),
                'a_name' => $object->getName()
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
        if($object instanceof Aliases) {
            $object->setId( isset($data['a_id']) ? $data['a_id']: null);
            $object->setName( isset($data['a_name']) ? $data['a_name']: null);
            return $object;
        }

        if( $object instanceof Prestation) {
            $aliases = explode(",",$data['aliases']);

            $aliasesList = array_map(function( $aliasString) {
                $aliasesArray = explode(':', $aliasString);
                $aliases = new Aliases();
                $aliases->setId($aliasesArray[0]);
                $aliases->setName($aliasesArray[1]);
                return $aliases;
            }, $aliases);

            $object->getKeyword()->setAliases($aliasesList);
           return $object;
        }


        return $object;
    }
}