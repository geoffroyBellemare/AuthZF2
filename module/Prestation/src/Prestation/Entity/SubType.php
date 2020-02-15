<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/09/2018
 * Time: 07:47
 */

namespace Prestation\Entity;


class SubType
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;

    public $k_id;
    /**
     * @var Slug[] $slugs
     */
    public $slugs;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return Slug[]
     */
    public function getSlugs()
    {
        return $this->slugs;
    }

    /**
     * @param Slug[] $slugs
     */
    public function setSlugs($slugs)
    {
        $this->slugs = $slugs;
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