<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 11:23
 */

namespace Prestation\Service;


use Prestation\Entity\Region;
use Prestation\Validator\EntityExistValidator;

class RegionServiceImpl extends KeywordServiceImpl2 implements RegionService
{

    /**
     * @var \Prestation\Repository\RegionRepository
     */
    public $regionRepository;


    public function __construct(\Prestation\Repository\RegionRepository $regionRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->regionRepository = $regionRepository;

    }


    /**
     * @param $data
     * @return \Prestation\Entity\Region
     */

    public function save($data)
    {
        if( !isset($data["region"]) ) return null;

        $keyword = $this->saveKeyword(4, $data["region"], []);

        $region = $this->regionRepository->findByName($data["region"]);
        if( !$region ){
            $region = new Region();
            $region->setKId($keyword->getId());
            $region->setName($data["region"]);
            $region->setId($this->regionRepository->create($region));
        }

        return $region;
    }


    /**
     * @param $data
     * @return Region|null
     */
    public  function saveFromBackup($data) {

        if( !isset($data["administrative_area_level_1"]) ) return null;

        $keyword = $this->saveKeyword(4, $data["administrative_area_level_1"], []);

        $region = $this->regionRepository->findByName($data["administrative_area_level_1"]);
        if( !$region ){
            $region = new Region();
            $region->setKId($keyword->getId());
            $region->setName($data["administrative_area_level_1"]);
            $region->setId($this->regionRepository->create($region));
        }

        return $region;
    }
}