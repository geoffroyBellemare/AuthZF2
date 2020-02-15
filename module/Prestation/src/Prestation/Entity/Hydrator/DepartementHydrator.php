<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 15:45
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Departement;
use Prestation\Entity\Prestation;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DepartementHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if($object instanceof Departement) {
            return [
                'd_id' => $object->getId(),
                'd_name' => $object->getName(),
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
        if($object instanceof Departement) {
            $object->setId(isset($data['d_id'])? $data['d_id']: null);
            $object->setName(isset($data['d_name'])? $data['d_name']: null);
            $object->setKId( isset( $data['k_id'])? $data['k_id']: null );
        }

        if($object instanceof Prestation) {
            if( isset($data['department']) ) {
                $departmentsString = $data['department'];
                $departmentList = explode(",", $departmentsString);
                $i = 0;
                array_map( function($departmentString) use ($object, &$i) {
                    $departmentAttributes = explode(":", $departmentString);
                    $department = new Departement();
                    $department->setId(isset($departmentAttributes[1]) ? $departmentAttributes[1]: null);
                    $department->setName(isset($departmentAttributes[2]) ? $departmentAttributes[2]: null);
                    $object->markers[$i]->setDepartement($department);
                    $i++;
                    // $department->setKId( isset( $data['d_k_id'])? $data['d_k_id']: null );
                }, $departmentList);
            }

        }

        return $object;
    }
}