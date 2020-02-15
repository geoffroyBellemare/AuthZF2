<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/06/2019
 * Time: 18:22
 */

namespace Prestation\Entity;


class Caption
{
    public $id;
    public $caption;

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
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

}