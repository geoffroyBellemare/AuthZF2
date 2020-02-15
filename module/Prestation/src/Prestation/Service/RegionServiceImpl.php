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

class RegionServiceImpl implements RegionService
{

    /**
     * @var \Prestation\Repository\RegionRepository
     */
    public $regionRepository;

    public $adapter;
    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    public $keywordService;

    /**
     * RegionServiceImpl constructor.
     * @param \Prestation\Repository\RegionRepository $regionRepository
     * @param $adapter
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct($adapter, \Prestation\Repository\RegionRepository $regionRepository, KeywordServiceImpl $keywordService)
    {
        $this->regionRepository = $regionRepository;
        $this->adapter = $adapter;
        $this->keywordService = $keywordService;
    }


    /**
     * @param $data
     * @return \Prestation\Entity\Region
     */

    public function save($data)
    {
        $region = $this->regionRepository->findByName($data['region']);

        if( !$region ) {
            $region = new Region();
            $region->setName($data['region']);
            $region->setId($this->regionRepository->create($region));
        }
        return $region;

    }

    /**
     * @param \Prestation\Entity\Region $region
     * @param \Prestation\Entity\Marker $marker
     * @return mixed
     */
    public function saveRelation($region, $marker)
    {
        $relation = $this->regionRepository->findRelation($region, $marker);

        if( !$relation ) {
            $this->regionRepository->createRelation($region, $marker);
        }
    }

    /**
     * @param $data
     * @param $marker
     * @return Region|null
     */
    public  function saveFromBackup($data, $marker) {

        if( !isset($data["administrative_area_level_1"]) ) return null;

        $keyword = $this->keywordService->save(4, $data["administrative_area_level_1"], []);

        $region = $this->regionRepository->findByName($data["administrative_area_level_1"]);
        if( !$region ){
            $region = new Region();
            $region->setKId($keyword->getId());
            $region->setName($data["administrative_area_level_1"]);
            $region->setId($this->regionRepository->create($region));
        }
/*        $region = new Region();
        $region->setKId($keyword->getId());
        $region->setName($data["administrative_area_level_1"]);
        $region->setId($this->regionRepository->create($region));

        if( !$region->getId() ){
            $region = $this->regionRepository->findByName($data["administrative_area_level_1"]);
        }*/
        if( $region ) {
            $this->regionRepository->createRelation($region, $marker);
        }
        return $region;
    }
}