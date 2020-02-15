<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 03/09/2018
 * Time: 16:44
 */

namespace Prestation\Entity;


use Zend\Db\Sql\Ddl\Column\Decimal;

class Prestation
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $k_id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var Decimal
     */
    public $price;
    /**
     * @var int
     */
    public $quantity;
    /**
     * @var string
     */
    public $owner;
    /**
     * @var \Prestation\Entity\Type
     */
    public $type;
    /**
     * @var int
     */
    public $created;
    /**
     * @var \Prestation\Entity\Marker
     */
    public $marker;
    /**
     * @var \Prestation\Entity\Marker[]
     */
    public $markers;
    /**
     * @var \Prestation\Entity\Address
     */
    public $address;
    /**
     * @var \Prestation\Entity\User
     */
    public $user;
    /**
     * @var \Prestation\Entity\Caption
     */
    public $caption;
    /**
     * @var array
     */
    public $ageCategory;
    /**
     * @var \Prestation\Entity\LevelCategory[]
     */
    public $levelCategory;
    /**
     * @var \Prestation\Entity\SportCategory[]
     */
    public $sportCategory;
    /**
     * @var SubType[]
     */
    public $subTypes;
    /**
     * @var \Prestation\Entity\Keyword
     */
    public $keyword;

    /**
     * Prestation constructor.
     */
    /**
     * @var array
     */
    public $p_keywords;
    /**
     * @var array
     */
    public $l_keywords;
    /**
     * @var array
     */
    public $t_keywords;
    /**
     * @var array
     */
    public $st_keywords;
    /**
     * @var array
     */
    public $d_keywords;
    /**
     * @var array
     */
    public $r_keywords;

    public function __construct()
    {
    }
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
     * @return int
     */
    public function getKId()
    {
        return $this->k_id;
    }

    /**
     * @param int $k_id
     */
    public function setKId($k_id)
    {
        $this->k_id = $k_id;
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
     * @return Decimal
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Decimal $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Marker
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * @param Marker $marker
     */
    public function setMarker($marker)
    {
        $this->marker = $marker;
    }

    /**
     * @return array
     */
    public function getAgeCategory()
    {
        return $this->ageCategory;
    }

    /**
     * @param []AgeCategory $ageCategory
     */
    public function setAgeCategory($ageCategory)
    {
        $this->ageCategory = $ageCategory;
    }

    /**
     * @return LevelCategory[]
     */
    public function getLevelCategory()
    {
        return $this->levelCategory;
    }

    /**
     * @param []LevelCategory $levelCategory
     */
    public function setLevelCategory($levelCategory)
    {
        $this->levelCategory = $levelCategory;
    }

    /**
     * @return SubType[]
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    /**
     * @param SubType[] $subTypes
     */
    public function setSubTypes($subTypes)
    {
        $this->subTypes = $subTypes;
    }

    /**
     * @return Keyword
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param Keyword $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return Marker[]
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * @param Marker[] $markers
     */
    public function setMarkers($markers)
    {
        $this->markers = $markers;
    }

    /**
     * @return array
     */
    public function getPKeywords()
    {
        return $this->p_keywords;
    }

    /**
     * @param array $p_keywords
     */
    public function setPKeywords($p_keywords)
    {
        $this->p_keywords = $p_keywords;
    }

    /**
     * @return array
     */
    public function getLKeywords()
    {
        return $this->l_keywords;
    }

    /**
     * @param array $l_keywords
     */
    public function setLKeywords($l_keywords)
    {
        $this->l_keywords = $l_keywords;
    }

    /**
     * @return array
     */
    public function getTKeywords()
    {
        return $this->t_keywords;
    }

    /**
     * @param array $t_keywords
     */
    public function setTKeywords($t_keywords)
    {
        $this->t_keywords = $t_keywords;
    }

    /**
     * @return array
     */
    public function getStKeywords()
    {
        return $this->st_keywords;
    }

    /**
     * @param array $st_keywords
     */
    public function setStKeywords($st_keywords)
    {
        $this->st_keywords = $st_keywords;
    }

    /**
     * @return array
     */
    public function getDKeywords()
    {
        return $this->d_keywords;
    }

    /**
     * @param array $d_keywords
     */
    public function setDKeywords($d_keywords)
    {
        $this->d_keywords = $d_keywords;
    }

    /**
     * @return array
     */
    public function getRKeywords()
    {
        return $this->r_keywords;
    }

    /**
     * @param array $r_keywords
     */
    public function setRKeywords($r_keywords)
    {
        $this->r_keywords = $r_keywords;
    }

    /**
     * @return SportCategory[]
     */
    public function getSportCategory()
    {
        return $this->sportCategory;
    }

    /**
     * @param SportCategory[] $sportCategory
     */
    public function setSportCategory($sportCategory)
    {
        $this->sportCategory = $sportCategory;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Caption
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param Caption $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }





}