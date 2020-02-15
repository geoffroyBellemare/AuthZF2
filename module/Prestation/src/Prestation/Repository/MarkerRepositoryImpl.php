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
        try {
            $sql = $this->getSql();
            $insert = $sql->insert($this->table)
                ->values(array(
                    'lat' => $marker->getLat(),
                    'lng' => $marker->getLng(),
                    'l_id' => $marker->getLocality()->getId(),
                    'c_id' => $marker->getCountry()->getId()
                ));
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
}