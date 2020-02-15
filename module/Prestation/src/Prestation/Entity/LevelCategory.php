<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 16:15
 */

namespace Prestation\Entity;


class LevelCategory
{
    public $id;
    public $name;

    /**
     * LevelCategory constructor.
     */
    public function __construct()
    {
    }


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




}