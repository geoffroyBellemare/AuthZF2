<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/05/2019
 * Time: 13:48
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\AgeCategory;
use Prestation\Entity\LevelCategory;
use Prestation\Entity\Period;
use Prestation\Entity\SubType;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PeriodHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof Period) {
            return [];
        }
        return [
            'pd_id' => $object->getPdId(),
            'pd_start' => $object->getPdStart(),
            'pd_end' => $object->getPdEnd(),
            'pd_year' => $object->getPdYear(),
            'pd_business_weekday' => $object->getPdBusinessWeekday(),
            'pd_price' => $object->getPdPrice(),
            'pd_quantity' => $object->getPdQuantity(),
            'p_id' => $object->getPId()
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
        if($object instanceof Period) {

            $object->setPdId(isset($data['pd_id'])? $data['pd_id']: null);
            $object->setPdStart(isset($data['pd_start'])?$data['pd_start']: null );
            $object->setPdEnd(isset($data['pd_end'])?$data['pd_end']: null );
            $object->setPdYear(isset($data['pd_year'])?$data['pd_year']: null );
            $object->setPdBusinessWeekday(isset($data['pd_business_weekday'])?$data['pd_business_weekday']: null );
            $object->setPdPrice(isset($data['pd_price'])?$data['pd_price']: null );
            $object->setPdQuantity(isset($data['pd_quantity'])?$data['pd_quantity']: null );
           // $object->setPdWeekStart(isset($data['pd_week_start'])?$data['pd_week_start']: null );
           // $object->setPdWeekEnd(isset($data['pd_week_end'])?$data['pd_week_end']: null );
            $object->setPId(isset($data['p_id'])?$data['p_id']: null );
           // $object->setPIdPrestation(isset($data['p_id_prestation'])?$data['p_id_prestation']:null);
           // $object->setPHostId(isset($data['p_id_prestation'])?$data['p_id_prestation']:null);

/*            if (isset($data['pd_age_categories'])) {
                $ageCategories = [];
                foreach ( explode(',', $data['pd_age_categories']) as $key => $value) {
                    list($c_a_id, $c_a_name) = explode(':', $value);
                    $ageCategory = new AgeCategory();
                    $ageCategory->setId($c_a_id);
                    $ageCategory->setName($c_a_name);
                    $ageCategories[] = $ageCategory;
                }
                if( count($ageCategories) > 0 )$object->setPdAgeCategory($ageCategories);
            }

            if (isset($data['pd_level_categories'])) {
                $levelCategories = [];
                foreach (explode(',', $data['pd_level_categories']) as $key => $value) {
                    list($c_l_id, $c_l_name) = explode(':', $value);
                    $levelCategory = new LevelCategory();
                    $levelCategory->setId($c_l_id);
                    $levelCategory->setName($c_l_name);
                    $levelCategories[] = $levelCategory;
                }
                if( count($levelCategories) > 0 )$object->setPdLevelCategory($levelCategories);
            }

            if (isset($data['pd_subtypes'])) {
                $subTypes = [];
                foreach (explode(',', $data['pd_subtypes']) as $key => $value) {
                    list($st_id, $st_name) = explode(':', $value);
                    $subtype = new SubType();
                    $subtype->setId($st_id);
                    $subtype->setName($st_name);
                    $subTypes[] = $subtype;
                }
                if( count($subTypes) > 0 )$object->setPdSubtypes($subTypes);
            }*/


        }
        return $object;
    }
}