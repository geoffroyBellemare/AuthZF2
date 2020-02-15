<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/09/2018
 * Time: 12:43
 */

namespace Prestation\Entity;


class Slug
{
    public $id;
    public $name;

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