<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 15:00
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Prestation;
use Prestation\Entity\Region;
use Zend\Stdlib\Hydrator\HydratorInterface;

class RegionHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Region){
            return [
                'r_id' => $object->getId(),
                'r_name' => $object->getName(),
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
        // TODO: Implement hydrate() method.
        if($object instanceOf Region ) {
            $object->setId(isset($data['r_id'])? $data['r_id']: null );
            $object->setName(isset($data['r_name'])? $data['r_name']: null);
            $object->setKId(isset($data['k_id'])? $data['k_id']: null);
        }

        if($object instanceOf Prestation ) {
            if( isset($data['region']) ) {
                $regionsString = $data['region'];
                $regionList = explode(",", $regionsString);
                $i = 0;
                array_map(function($regionString) use($object, &$i) {
                    $regionAttributes = explode(":", $regionString);
                    $region = new Region();
                    $region->setId(isset($regionAttributes[1])? $regionAttributes[1]: null );
                    $region->setName(isset($regionAttributes[2])? $regionAttributes[2]: null);

                    //k_id !!!!!!!!!!!!!//
                    //////////////////////
                    $object->markers[$i]->setRegion($region);
                    $i++;
                }, $regionList);
            }
/*
            $object->getMarker()->setRegion($region);*/
        }
        return $object;
    }
}