<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 17:26
 */

namespace Prestation\Service;


use Prestation\Entity\Locality;

class LocalityServiceImpl implements LocalityService
{

    /**
     * @var \Prestation\Repository\LocalityRepository
     */
    public $localityRepository;
    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    public $keywordService;

    /**
     * LocalityServiceImpl constructor.
     * @param \Prestation\Repository\LocalityRepository $localityRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct(\Prestation\Repository\LocalityRepository $localityRepository, KeywordServiceImpl $keywordService)
    {
        $this->localityRepository = $localityRepository;
        $this->keywordService = $keywordService;
    }


    /**
     * @param $data
     * @return mixed
     */
    public function save($data)
    {

        $locality = $this->localityRepository->findByName($data['locality']);
        if(!$locality) {
            $locality = new Locality();
            $locality->setName($data['locality']);
            $locality->setPostcode($data['postcode']);
            $locality->setId($this->localityRepository->create($locality));
        }
        return $locality;
    }

    public function saveFromBackup($data) {

        $keyword = $this->keywordService->save(2, $data['locality'], []);

/*        $locality = new Locality();
        $locality->setKId($keyword->getId());
        $locality->setName($data['locality']);
        $locality->setPostcode($data['postcode']);
        $locality->setId($this->localityRepository->create($locality));

        if( !$locality->getId() ) {
            $locality = $this->localityRepository->findByName($data['locality']);
        }
        return $locality;*/
        $locality = $this->localityRepository->findByName($data['locality']);
        if(!$locality) {
            $locality = new Locality();
            $locality->setKId($keyword->getId());
            $locality->setName($data['locality']);
            $locality->setPostcode($data['postcode']);
            $locality->setId($this->localityRepository->create($locality));
        }
        return $locality;
    }
}