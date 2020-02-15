<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/05/2019
 * Time: 15:05
 */

namespace Prestation\Entity;


class Prestataire extends User
{
    protected $rib;
    protected $diplome_id;

    /**
     * @return mixed
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * @param mixed $rib
     */
    public function setRib($rib)
    {
        $this->rib = $rib;
    }

    /**
     * @return mixed
     */
    public function getDiplomeId()
    {
        return $this->diplome_id;
    }

    /**
     * @param mixed $diplome_id
     */
    public function setDiplomeId($diplome_id)
    {
        $this->diplome_id = $diplome_id;
    }

}