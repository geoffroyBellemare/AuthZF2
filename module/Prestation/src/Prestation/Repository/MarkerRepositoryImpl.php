<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 19:29
 */

namespace Prestation\Repository;


use Prestation\Entity\Country;
use Prestation\Entity\Departement;
use Prestation\Entity\Hydrator\CountryHydrator;
use Prestation\Entity\Hydrator\CountryHydrator2;
use Prestation\Entity\Hydrator\DepartementHydrator;
use Prestation\Entity\Hydrator\LocalityHydrator;
use Prestation\Entity\Hydrator\MarkerHydrator;
use Prestation\Entity\Hydrator\Mhydrator;
use Prestation\Entity\Marker;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

class MarkerRepositoryImpl implements MarkerRepository
{

    use AdapterAwareTrait;
    public $table = 'marker';
    /**
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function create($marker)
    {

        $hydrator = new MarkerHydrator();
        $values = $hydrator->extract($marker);

        try {
            $sql = $this->getSql();
            $insert = $sql->insert($this->table)
                ->values($values);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch (\Exception $e ) {
            return null;
        }

    }

    /**
     * @param Marker $lat
     * @param $lng
     * @return null|object|Marker
     */
    public function findBy($lat, $lng)
    {
        /**
         *  DISTANCE in miles
         *           $startLat = 43.301370;
        $startLng = 3.4840850;
        'distance'=>new Expression("ACOS(COS(RADIANS(m.lat)) * COS(RADIANS(?)) * COS(RADIANS(?) - RADIANS(lng)) + SIN(RADIANS(lat)) * SIN(radians(?)))",array($startLat, $startLng,$startLat)),
        'distance' => new Expression("SQRT(
        POW(69.1 * (lat - ?), 2) +
        POW(69.1 * (? - lng) * COS(lat / 57.3), 2))",
        array($startLat, $startLng))
         */
        $latlng = array(
            'lat = '.$lat,
            'lng = '.$lng
        );

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('m' => 'marker'))
                ->columns(array(
                    'm_id',
                    'lat',
                    'lng',
                    'l_id',
                    'c_id',
                    'd_id',
                    'r_id',
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
             array('d' => 'department'),
             'd.d_id = m.d_id',
             array('d_name'),
             $select::JOIN_LEFT
            )
            ->join(
                array('r' => 'region'),
                'r.r_id = m.r_id',
                array('r_name'),
                $select::JOIN_LEFT
            )
            ->where($latlng);

        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new MarkerHydrator() , new Marker());
        $resultSet->initialize($result);
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }

    /**
     * @param \Prestation\Entity\Marker $marker
     * @param \Prestation\Entity\Prestation $prestation
     * @return mixed
     */
    public function createRelation($marker, $prestation)
    {
        // TODO: Implement createRelation() method.
    }

    /**
     * @param $data
     * @return false|mixed
     */
    public function isFree($data)
    {
        var_dump('isfree');
        var_dump($data);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $sql = $this->getSql();
        $select = $sql->select();
        $select
            ->from(array('p'=> 'prestation'))
            ->columns(array('p_id'))
            ->join(
                array('ml' => 'marker_linker'),
                'ml.p_id = p.p_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('pd' => 'period'),
                'p.p_id = pd.p_id',
                array(
                    'pd_start',
                    'pd_end'
                ),
                $select::JOIN_INNER
            )
            ->join(
                array('h' => 'horaire'),
                'h.pd_id = pd.pd_id',
                array(
                    'h_start',
                    'h_end'
                ),
                $select::JOIN_LEFT
            )
            ->join(
                array('m' => 'marker'),
                'ml.m_id = m.m_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('t' => 'type'),
                't.t_id = p.t_id',
                array('*'),
                $select::JOIN_INNER
            )
            ->join(
                array('l' => 'locality'),
                'l.l_id = m.l_id',
                array('*'),
                $select::JOIN_INNER
            )

            ->where(array(
                'p.p_name' => $data['name'],
                'p.t_id' => $data['type'],
                'l.l_name' => $data['locality']
                /*'p.p_id' => $prestation->getId(),
                'pd.pd_start <= ?' => $period->getPdStart(),
                'pd.pd_end >= ?' => $period->getPdEnd(),
                'h.h_start = ?' => $horaire->getHStart()*/
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $results = $statment->execute();
        var_dump($results->current());
        return $results->current();
    }
}