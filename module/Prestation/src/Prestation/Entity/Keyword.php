<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 15:21
 */

namespace Prestation\Entity;


class Keyword extends Name
{
    /**
     * @var \Prestation\Entity\Aliases[]
     */
    public $aliases;
    /**
     * Keyword constructor.
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

    /**
     * @return Aliases[]
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param Aliases[] $aliases
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

}