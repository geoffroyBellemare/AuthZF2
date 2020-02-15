<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/09/2018
 * Time: 18:17
 */

namespace Prestation\Service;


use Admin\Utils\Backup;
use Admin\Utils\BackupFilter;
use Cocur\Slugify\Slugify;
use Prestation\Entity\SubType;

class SubTypeServiceImpl implements SubTypeService
{
    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    protected $keywordService;
    /**
     * @var \Prestation\Repository\SubTypeRepository $subTypeRepository
     */
    protected $subTypeRepository;
    /**
     * @var \Prestation\Repository\SlugRepository
     */
    protected $slugRepository;
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $adapter;
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return \Prestation\Entity\SubType
     */
    public function save($subType)
    {
        //($subType);
        $subType->setId($this->subTypeRepository->save($subType));

        if(!$subType->getId()) {
            $subType = $this->subTypeRepository->findByName($subType->getName());
        }
        return $subType;
/*     ???????
        $connection = $this->adapter->getDriver()->getConnection();
        try{

            $connection->beginTransaction();
            $st_id = $this->subTypeRepository->save($subType);
           foreach ( $subType->getSlugs() as $slug ) {

                $this->slugRepository->save($slug, 2, $st_id);
            }
            $connection->commit();

        } catch (\Exception $execption) {
            $connection->rollback();
        }*/

/*
        foreach ( $subType->getSlugs() as $slug ) {
            $this->slugRepository->save($slug,2,$st_id);
        }*/
    }

    /**
     * @param $name
     * @param $aliases
     * @return null|SubType
     */
    public function save2( $name, $aliases ) {
        $keyword = $this->keywordService->save(6, $name, $aliases );

        $subType = $this->subTypeRepository->findByName($name);
        if( !$subType ) {
            $subType = new SubType();
            $subType->setName($name);
            $subType->setKId($keyword->getId());
            $subType->setId($this->subTypeRepository->save($subType));
        }
/*        $subType = new SubType();
        $subType->setName($name);
        $subType->setKId($keyword->getId());
        $subType->setId($this->subTypeRepository->save($subType));

        if( !$subType->getId() ) {
            $subType = $this->subTypeRepository->findByName($name);
        }*/

        return $subType;
    }
    /**
     * @param $data
     * @return null|SubType[]
     */
    public function saveFromBackup($data) {

        $slugify = new Slugify();
        $subtypes = [];
        $subtypesList = [];

        $subtypes[]= ['keyword' => $data['type'], 'aliases' => BackupFilter::findAliases($data['type'])];
        $subtypes[]= ['keyword' => $data['the_main'], 'aliases' => BackupFilter::findAliases($data['the_main'])];

        $subtypes[0]['aliases'][] = $slugify->slugify($data['type'], " ");
        $subtypes[1]['aliases'][] = $slugify->slugify($data['the_main'], " ");

        //var_dump( $subtypes );
        foreach ($subtypes as $key => $keywords) {
            $name = $keywords['keyword'];
            $aliases = $keywords['aliases'];
            $subType = $this->save2($name, $aliases);

            if ( $subType ){
                $subtypesList[] = $subType;
            }
        }
        return count($subtypesList) > 0 ? $subtypesList: null;

    }
    /**
     * @return SubType[] $subTypes
     */
    public function fetch()
    {
        return $this->subTypeRepository->fetch();
    }
    /**
     * @param $id
     * @return SubType $subType|null
     */
    public function findById($id)
    {
        return $this->subTypeRepository->findById($id);
    }
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function update($subType)
    {
        //TODO
        /*
         * 1)dans tt les update du ss type
         * 2)pour les slug??
         * A)!!!ne pas updater le les slug
         * B)le creer si existe pas
         * C) linker si il existe
         */
        try {

            $this->adapter->getDriver()->getConnection()->beginTransaction();
            var_dump($subType);
            $this->subTypeRepository->update($subType);

            foreach ($subType->getSlugs() as $slug ) {

                  $this->slugRepository->save($slug,2, $subType->getId());

            }

            $this->adapter->getDriver()->getConnection()->commit();
        } catch ( \Exception $exception) {
            $this->adapter->getDriver()->getConnection()->rollback();
        }

    }


    public function setSubTypeRepository($subTypeRepository)
    {
        $this->subTypeRepository = $subTypeRepository;
    }

    /**
     * @param mixed $slugRepository
     */
    public function setSlugRepository($slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * @param mixed $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return KeywordServiceImpl
     */
    public function getKeywordService()
    {
        return $this->keywordService;
    }

    /**
     * @param KeywordServiceImpl $keywordService
     */
    public function setKeywordService($keywordService)
    {
        $this->keywordService = $keywordService;
    }


}