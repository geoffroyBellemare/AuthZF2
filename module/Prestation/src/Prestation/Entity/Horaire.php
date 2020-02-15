<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 14:19
 */

namespace Prestation\Entity;


class Horaire
{

    public $h_id;
    public $pd_id;
    public $h_start;
    public $h_end;
    public $h_day;
    public $h_provider;

    /**
     * @return mixed
     */
    public function getHId()
    {
        return $this->h_id;
    }

    /**
     * @param mixed $h_id
     */
    public function setHId($h_id)
    {
        $this->h_id = $h_id;
    }

    /**
     * @return mixed
     */
    public function getPdId()
    {
        return $this->pd_id;
    }

    /**
     * @param mixed $pd_id
     */
    public function setPdId($pd_id)
    {
        $this->pd_id = $pd_id;
    }

    /**
     * @return mixed
     */
    public function getHStart()
    {
        return $this->h_start;
    }

    /**
     * @param mixed $h_start
     */
    public function setHStart($h_start)
    {
        $this->h_start = $h_start;
    }

    /**
     * @return mixed
     */
    public function getHEnd()
    {
        return $this->h_end;
    }

    /**
     * @param mixed $h_end
     */
    public function setHEnd($h_end)
    {
        $this->h_end = $h_end;
    }

    /**
     * @return mixed
     */
    public function getHDay()
    {
        return $this->h_day;
    }

    /**
     * @param mixed $h_day
     */
    public function setHDay($h_day)
    {
        $this->h_day = $h_day;
    }

    /**
     * @return mixed
     */
    public function getHProvider()
    {
        return $this->h_provider;
    }

    /**
     * @param mixed $h_provider
     */
    public function setHProvider($h_provider)
    {
        $this->h_provider = $h_provider;
    }



}