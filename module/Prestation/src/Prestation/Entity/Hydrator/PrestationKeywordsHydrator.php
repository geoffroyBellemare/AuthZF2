<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 07/12/2018
 * Time: 15:59
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Prestation;
use Prestation\Entity\PrestationKeyword;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PrestationKeywordsHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof PrestationKeyword ){
            return ['ffff'];
        }
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
        if(!$object instanceof PrestationKeyword ) {
            return $object;
        }
        if( isset($data['c_keywords']) ) {
            $c_keywords = $this->hydratorHelper($data['c_keywords']);
            $object->setCKeywords($c_keywords);
        }
        if( isset($data['p_keywords']) ) {
            $p_keywords = $this->hydratorHelper($data['p_keywords']);
            $object->setPKeywords($p_keywords);
        }
        if( isset($data['l_keywords']) ) {
            $l_keywords = $this->hydratorHelper($data['l_keywords']);
            $object->setLKeywords($l_keywords);
        }
        if( isset($data['t_keywords']) ) {

            $t_keywords = $this->hydratorHelper($data['t_keywords']);
            $object->setTKeywords($t_keywords);
        }
        if( isset($data['sub_types']) ) {
            //var_dump($data['p_keywords']);
            $st_keywords = [];
            $keywordsString = explode(',',$data['sub_types']);
            foreach ($keywordsString as $keywordString) {
                list($e_id, $k_id, $a_name) = explode(':', $keywordString);
                if( !isset( $st_keywords[$k_id] ) ){
                    $st_keywords[$k_id] = [ $a_name ];
                } else {
                    $st_keywords[$k_id][] = $a_name;
                }
            }
            $object->setStKeywords($st_keywords);
        }
        if( isset($data['d_keywords']) ) {
            $d_keywords = $this->hydratorHelper($data['d_keywords']);
            $object->setDKeywords($d_keywords);
        }
        if( isset($data['r_keywords']) ) {
            $r_keywords = $this->hydratorHelper($data['r_keywords']);
            $object->setRKeywords($r_keywords);
        }
        return $object;
    }
    private function hydratorHelper($data) {
        $keywords = [];
        $keywordsString = explode(',',$data);
        foreach ($keywordsString as $keywordString) {
            list($k_id, $a_name) = explode(':', $keywordString);
            if( !isset( $keywords[$k_id] ) ){
                $keywords[$k_id] = [ $a_name ];
            } else {
                $keywords[$k_id][] = $a_name;
            }
        }
        return $keywords;
        }
}