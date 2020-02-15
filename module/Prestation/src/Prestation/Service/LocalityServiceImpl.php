<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 17:26
 */

namespace Prestation\Service;


use Prestation\Entity\Locality;

class LocalityServiceImpl extends KeywordServiceImpl2 implements LocalityService
{

    /**
     * @var \Prestation\Repository\LocalityRepository
     */
    public $localityRepository;



    public function __construct(\Prestation\Repository\LocalityRepository $localityRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->localityRepository = $localityRepository;

    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
        $keyword = $this->saveKeyword(2, $data['locality'], []);
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

    public function saveFromBackup($data) {

        $keyword = $this->saveKeyword(2, $data['locality'], []);

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