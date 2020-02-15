<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 21:52
 */

namespace Prestation\Entity;


class Address
{
    public $id;
    public $name;
    public $l_id;
    public $c_id;
    public $r_id;
    public $d_id;
    public $k_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLId()
    {
        return $this->l_id;
    }

    /**
     * @param mixed $l_id
     */
    public function setLId($l_id)
    {
        $this->l_id = $l_id;
    }

    /**
     * @return mixed
     */
    public function getCId()
    {
        return $this->c_id;
    }

    /**
     * @param mixed $c_id
     */
    public function setCId($c_id)
    {
        $this->c_id = $c_id;
    }

    /**
     * @return mixed
     */
    public function getRId()
    {
        return $this->r_id;
    }

    /**
     * @param mixed $r_id
     */
    public function setRId($r_id)
    {
        $this->r_id = $r_id;
    }

    /**
     * @return mixed
     */
    public function getDId()
    {
        return $this->d_id;
    }

    /**
     * @param mixed $d_id
     */
    public function setDId($d_id)
    {
        $this->d_id = $d_id;
    }

    /**
     * @return mixed
     */
    public function getKId()
    {
        return $this->k_id;
    }

    /**
     * @param mixed $k_id
     */
    public function setKId($k_id)
    {
        $this->k_id = $k_id;
    }


}