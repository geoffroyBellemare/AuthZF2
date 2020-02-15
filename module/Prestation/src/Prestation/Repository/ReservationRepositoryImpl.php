<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/07/2019
 * Time: 20:52
 */

namespace Prestation\Repository;


use Prestation\Entity\Prestataire;
use Prestation\Entity\Prestation;
use Prestation\Entity\Reservation;
use Prestation\Entity\User;
use Prestation\Utils\DateManipulation;
use Prestation\Utils\Fields;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;

class ReservationRepositoryImpl implements ReservationRepository
{
    private $table = 'reservation';
    use Fields, AdapterAwareTrait;
    /**
     * @param Reservation $reservation
     * @param int $start
     * @param int $end
     * @param int $quantity
     * @param Prestation $prestation
     * @param Prestataire $prestataire
     * @return mixed
     */
    public function create($reservation)
    {

        $rv_id = null;
        $values = array(
            'user_id' => $reservation->getUserId(),
            'p_id' => $reservation->getPId(),
            'pr_id' => $reservation->getPrId(),
            'rv_start' => $reservation->getRvStart(),
            'rv_end' => $reservation->getRvEnd(),
            'rv_quantity' => $reservation->getRvQuantity(),
        );

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $sql = new \Zend\Db\Sql\Sql($this->adapter);
            $insert = $sql->insert()
                ->values($values)
                ->into($this->table);
            $statment = $sql->prepareStatementForSqlObject($insert);
            $statment->execute();

            $rv_id = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();

            $this->adapter->getDriver()->getConnection()->commit();

        } catch (\Exception $e ) {
            var_dump($e->getMessage());
            $this->adapter->getDriver()->getConnection()->rollback();

        }
        return $rv_id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByPID($id, $time = null)
    {
        $target = array('p.p_id = ?' => $id);
        if ($time) {

            $target['rv_start <= ?'] = DateManipulation::convertDateStringToTimeStamp($time['start']);
            $target['rv_end >= ?'] = DateManipulation::convertDateStringToTimeStamp($time['end']);
        }

        $sql= new \Zend\Db\Sql\Sql($this->adapter);
        $select  = $sql->select();
        $select->from(array('p' => $this->table))
            ->columns(
                $this->reservationFields
            )
            ->where($target);
        //'created_at >= ?' => date('Y-m-d H:i:s', time() - 86400 * 30)
        $statment = $sql->prepareStatementForSqlObject($select);
        $result = $statment->execute();

       $resultSet = new HydratingResultSet(new ClassMethods(True), new Reservation());
       $resultSet->initialize($result);
       return $resultSet->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByPrestataire($id)
    {
        // TODO: Implement findByPrestataire() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $target = array('rv_id' => $id);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);

        try {
            $this->adapter->getDriver()->getConnection()->beginTransaction();

            $delete = $sql->delete()->from($this->table)->where($target);
            $statement = $sql->prepareStatementForSqlObject($delete);
            $statement->execute();

            $this->adapter->getDriver()->getConnection()->commit();
        } catch (\Exception $error ){
            $this->adapter->getDriver()->getConnection()->rollback();
        }
    }
}