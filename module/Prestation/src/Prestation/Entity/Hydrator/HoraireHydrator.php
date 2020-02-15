<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 01:12
 */

namespace Prestation\Entity\Hydrator;



use Prestation\Entity\Horaire;
use Zend\Stdlib\Hydrator\HydratorInterface;

class HoraireHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof Horaire) {
            return [

            ];
        }
        return [
            'h_id' => $object->getHId(),
            'h_start' => $object->getHStart(),
            'h_end' => $object->getHEnd(),
            'h_day' => $object->getHDay()
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
        if($object instanceof Horaire) {
            $object->setHId(isset($data['h_id'])? $data['h_id']: null);
            $object->setHStart(isset($data['h_start'])? $data['h_start']: null);
            $object->setHEnd(isset($data['h_end'])? $data['h_end']: null);
            $object->setHDay(isset($data['h_day'])? $data['h_day']: null);
            $object->setPdId(isset($data['pd_id'])? $data['pd_id']: null);
        }
        return $object;
    }
}