<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 19:43
 */

namespace Prestation\Entity;


class Entreprise extends Prestataire
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $siret;

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
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    }


}