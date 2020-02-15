<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 03/09/2018
 * Time: 16:50
 */

namespace Prestation\Entity\Hydrator;

use Prestation\Entity\Prestation;
use Prestation\Entity\SubType;
use Zend\Stdlib\Hydrator\HydratorInterface;

class SubTypeHydrator implements HydratorInterface
{

    /**
     * @param SubType $object
     * @return array
     */
    public function extract($object) {
        if(!$object instanceof Prestation) {
            return $object;
        }
        $subTypeStr = '';
        $count = 0;
        $lgt = count($object->getSubTypes());
        foreach ($object->getSubTypes() as $subType) {
            if($count != $lgt-1  && $lgt > 1 ) {
                $subTypeStr = $subTypeStr . $subType->getId .':'. $subType->getName().',';
            } else {
                $subTypeStr = $subTypeStr . $subType->getId .':'. $subType->getName();
            }
            $count++;
        }
        return array(
            //'sub_types' => $subTypeStr
        );
    }
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  SubType $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {

        if ($object instanceof Prestation ){

            if(isset($data['sub_types'])) {

                $subTypes = array();
                $subTypesStr = explode(',',$data['sub_types']);
                foreach ($subTypesStr as $subTypeStr) {
                    list($id, $name)= explode(':', $subTypeStr);
                    $subtType = new SubType();
                    $subtType->setId($id);
                    $subtType->setName($name);
                    $subTypes[] = $subtType;
                    //$subTypes[] = $id.':'.$name;
                }
                $object->setSubTypes($subTypes);
            }
        } else if ($object instanceof SubType ) {

            $object->setId( isset($data['st_id']) ? $data['st_id']: null );
            $object->setName(isset($data['st_name']) ? $data['st_name']: null);
            $object->setKId(isset($data['k_id'])? $data['k_id']: null);
            //$object->setSlugs( $slugs);

            if(!is_null($data['slugs'])) {
                $slugs = explode(',',$data['slugs']);
                $object->setSlugs( array_map(function($slug) {
                    list($id, $name)  = explode(':',$slug);

                    return ['id'=> $id, 'name'=>  $name];
                },$slugs));
            }


            //return $object;
        }

/*        $object->setId(isset($data['st_id']) ? $data['st_id'] : null );
        $object->setName( isset($data['st_name'])? $data['st_name'] : null );*/

        return $object;
    }
}