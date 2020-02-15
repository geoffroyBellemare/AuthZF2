<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/07/2019
 * Time: 15:00
 */

namespace Prestation\Entity;


class Reservation
{
    public $rv_id;
    public $rv_start;
    public $rv_end;
    public $rv_quantity;
    public $user_id;
    public $p_id = null;
    public $pr_id = null;

    /**
     * @return mixed
     */
    public function getRvId()
    {
        return $this->rv_id;
    }

    /**
     * @param mixed $rv_id
     */
    public function setRvId($rv_id)
    {
        $this->rv_id = $rv_id;
    }

    /**
     * @return mixed
     */
    public function getRvStart()
    {
        return $this->rv_start;
    }

    /**
     * @param mixed $rv_start
     */
    public function setRvStart($rv_start)
    {
        $this->rv_start = $rv_start;
    }

    /**
     * @return mixed
     */
    public function getRvEnd()
    {
        return $this->rv_end;
    }

    /**
     * @param mixed $rv_end
     */
    public function setRvEnd($rv_end)
    {
        $this->rv_end = $rv_end;
    }

    /**
     * @return mixed
     */
    public function getRvQuantity()
    {
        return $this->rv_quantity;
    }

    /**
     * @param mixed $rv_quantity
     */
    public function setRvQuantity($rv_quantity)
    {
        $this->rv_quantity = $rv_quantity;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return null
     */
    public function getPId()
    {
        return $this->p_id;
    }

    /**
     * @param null $p_id
     */
    public function setPId($p_id)
    {
        $this->p_id = $p_id;
    }

    /**
     * @return null
     */
    public function getPrId()
    {
        return $this->pr_id;
    }

    /**
     * @param null $pr_id
     */
    public function setPrId($pr_id)
    {
        $this->pr_id = $pr_id;
    }


}