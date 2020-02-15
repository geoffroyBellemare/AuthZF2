<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 19:53
 */

namespace Prestation\Repository;


use Prestation\Entity\Entreprise;
use Prestation\Entity\Period;
use Prestation\Entity\Prestation;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;

class VendreRepositoryImpl implements VendreRepository
{

    private $table = 'vendre';
    use AdapterAwareTrait;

    /**
     * @param Entreprise $entreprise
     * @param Prestation $prestation
     * @param Prestation $spot
     * @param Period $period
     * @return mixed
     */
    public function create($entreprise, $prestation, $spot, $period)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'user_id' => $entreprise->getUserId(),
                    'name' => $entreprise->getName(),
                    'p_id' => $prestation->getId(),
                    'p_id_prestation' => $spot->getId(),
                    'pd_id' => $period->getPdId(),
                    'tarif_location' => 0
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch ( \Exception $e ) {
            var_dump($e->getMessage());
            return null;
        }
    }

    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}