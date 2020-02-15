<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 24/05/2019
 * Time: 14:41
 */

namespace Prestation\Entity;


class Period
{
    /**
     * @var int
     */
    protected $pd_id;
    /**
     * @var int
     */
    protected $pd_start;
    /**
     * @var int
     */
    protected $pd_end;
    /**
     * @var int
     */
    protected $pd_year;
    /**
     * @var int
     */
    protected $pd_business_weekday;
    /**
     * @var int
     */
    protected $pd_price;
    /**
     * @var int
     */
    protected $pd_quantity;

    /**
     * @var int
     */
    protected $p_id;
    /**
     * @var int
     */
    protected $p_id_prestation;
    /**
     * @var Horaire[]
     */
    protected $horaires;

    /**
     * @var LevelCategory[]
     */
    protected $pd_level_category;
    /**
     * @var AgeCategory[]
     */
    protected $pd_age_category;
    /**
     * @var SubType[]
     */
    protected $pd_subtypes;
    /**
     * @return int
     */

    public function getPdId()
    {
        return $this->pd_id;
    }

    /**
     * @param int $pd_id
     */
    public function setPdId($pd_id)
    {
        $this->pd_id = $pd_id;
    }

    /**
     * @return int
     */
    public function getPdStart()
    {
        return $this->pd_start;
    }

    /**
     * @param int $pd_start
     */
    public function setPdStart($pd_start)
    {
        $this->pd_start = $pd_start;
    }

    /**
     * @return int
     */
    public function getPdEnd()
    {
        return $this->pd_end;
    }

    /**
     * @param int $pd_end
     */
    public function setPdEnd($pd_end)
    {
        $this->pd_end = $pd_end;
    }

    /**
     * @return int
     */
    public function getPdYear()
    {
        return $this->pd_year;
    }

    /**
     * @param int $pd_year
     */
    public function setPdYear($pd_year)
    {
        $this->pd_year = $pd_year;
    }

    /**
     * @return int
     */
    public function getPdBusinessWeekday()
    {
        return $this->pd_business_weekday;
    }

    /**
     * @param int $pd_business_weekday
     */
    public function setPdBusinessWeekday($pd_business_weekday)
    {
        $this->pd_business_weekday = $pd_business_weekday;
    }

    /**
     * @return int
     */
    public function getPdPrice()
    {
        return $this->pd_price;
    }

    /**
     * @param int $pd_price
     */
    public function setPdPrice($pd_price)
    {
        $this->pd_price = $pd_price;
    }

    /**
     * @return int
     */
    public function getPdQuantity()
    {
        return $this->pd_quantity;
    }

    /**
     * @param int $pd_quantity
     */
    public function setPdQuantity($pd_quantity)
    {
        $this->pd_quantity = $pd_quantity;
    }


    /**
     * @return int
     */
    public function getPId()
    {
        return $this->p_id;
    }

    /**
     * @param int $p_id
     */
    public function setPId($p_id)
    {
        $this->p_id = $p_id;
    }

    /**
     * @return Horaire[]
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * @param Horaire[] $horaires
     */
    public function setHoraires($horaires)
    {
        $this->horaires = $horaires;
    }

    /**
     * @return int
     */
    public function getPIdPrestation()
    {
        return $this->p_id_prestation;
    }

    /**
     * @param int $p_id_prestation
     */
    public function setPIdPrestation($p_id_prestation)
    {
        $this->p_id_prestation = $p_id_prestation;
    }


    /**
     * @return LevelCategory[]
     */
    public function getPdLevelCategory()
    {
        return $this->pd_level_category;
    }

    /**
     * @param LevelCategory[] $pd_level_category
     */
    public function setPdLevelCategory($pd_level_category)
    {
        $this->pd_level_category = $pd_level_category;
    }

    /**
     * @return AgeCategory[]
     */
    public function getPdAgeCategory()
    {
        return $this->pd_age_category;
    }

    /**
     * @param AgeCategory[] $pd_age_category
     */
    public function setPdAgeCategory($pd_age_category)
    {
        $this->pd_age_category = $pd_age_category;
    }



    /**
     * @return SubType[]
     */
    public function getPdSubtypes()
    {
        return $this->pd_subtypes;
    }

    /**
     * @param SubType[] $pd_subtypes
     */
    public function setPdSubtypes($pd_subtypes)
    {
        $this->pd_subtypes = $pd_subtypes;
    }


}