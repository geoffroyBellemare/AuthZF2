<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 20/05/2019
 * Time: 19:21
 */

namespace Prestation\Validator;


use Prestation\Entity\Hydrator\MarkerHydrator;
use Prestation\Entity\Marker;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Validator\Db\AbstractDb;
use Zend\Validator\Exception;

class MarkerLatLngNoRecordExist extends AbstractDb
{

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {

        $sql  = new \Zend\Db\Sql\Sql($this->adapter);

        $latlng = array(
            'lat = '.$value['lat'],
            'lng = '.$value['lng']
        );

        $select = $sql->select();
        $select->from(array('m' => 'marker'))
            ->columns(array(
                'm_id',
                'lat',
                'lng',
                'l_id',
                'c_id',
            ))
            ->join(
                array('c' => 'country'),
                'm.c_id = c.c_id',
                array('c_name', 'c_code'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'm.l_id = l.l_id',
                array('l_name','l_postcode'),
                $select::JOIN_INNER
            )
            ->join(
                array('dl' => 'department_linker'),
                'm.m_id = dl.m_id',
                array('d_id'),
                $select::JOIN_LEFT
            )
            ->join(
                array('d' => 'department'),
                'd.d_id = dl.d_id',
                array('d_name'),
                $select::JOIN_LEFT
            )
            ->join(
                array('rl' => 'region_linker'),
                'rl.m_id = m.m_id',
                array('r_id'),
                $select::JOIN_LEFT
            )
            ->join(
                array('r' => 'region'),
                'r.r_id = rl.r_id',
                array('r_name'),
                $select::JOIN_LEFT
            )
            ->where($latlng);

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new MarkerHydrator() , new Marker());
        $resultSet->initialize($result);
        return $resultSet->count() > 0 ? false : true;
    }
}