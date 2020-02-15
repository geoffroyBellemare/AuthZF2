<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 11:56
 */

namespace Prestation\Entity;


class SportCategory
{
    public $id;
    public $name;
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