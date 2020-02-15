<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 21:31
 */

namespace Prestation\Repository;


use Prestation\Entity\Entreprise;
use Prestation\Entity\Hydrator\EntrepriseHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;

class EntrepriseRepositoryImpl implements EntrepriseRepository
{
    private $table = 'entreprise';
    use AdapterAwareTrait;
    /**
     * @param Entreprise $entreprise
     * @return int|null
     */
    public function create($entreprise)
    {
        try {
            $sql = $this->getSql();
            $insert = $sql->insert()
                ->values(array(
                    'user_id' => $entreprise->getUserId(),
                    'name' => $entreprise->getName(),
                    'siret' => $entreprise->getSiret(),
                    'email' => $entreprise->getEmail(),
                    'rib' => $entreprise->getRib(),
                    'user_name' => $entreprise->getUserName()
                ))
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        } catch ( \Exception $e ) {
            return null;
        }
    }

    /**
     * @param $name
     * @return Entreprise|null
     */
    public function findByName($name)
    {
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'name' => $name
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new EntrepriseHydrator(), new Entreprise());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }

    /**
     * @param $user_id
     * @return Entreprise|null
     */
    public function fetchByUserId($user_id)
    {
        $sql = $this->getSql();
        $select = $sql->select()
            ->columns(array('*'))
            ->from($this->table)
            ->where(array(
                'user_id' => $user_id
            ));
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();
        $resultSet = new HydratingResultSet(new EntrepriseHydrator(), new Entreprise());
        $resultSet->initialize($result);

        return $resultSet->count() > 0 ? $resultSet->current(): null;
    }
    /**
     * @return \Zend\Db\Sql\Sql
     */
    private function getSql() {
        return new \Zend\Db\Sql\Sql($this->adapter);
    }
}