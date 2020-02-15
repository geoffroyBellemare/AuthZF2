<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 05/09/2018
 * Time: 18:17
 */

namespace Prestation\Service;


use Prestation\Utils\Backup;
use Prestation\Utils\BackupFilter;
use Cocur\Slugify\Slugify;
use Prestation\Entity\SubType;

class SubTypeServiceImpl extends KeywordServiceImpl2 implements SubTypeService
{

    /**
     * @var \Prestation\Repository\SubTypeRepository $subTypeRepository
     */
    protected $subTypeRepository;


    /**
     * TypeServiceImpl constructor.
     * @param \Prestation\Repository\SubTypeRepository $subTypeRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct(\Prestation\Repository\SubTypeRepository $subTypeRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->subTypeRepository = $subTypeRepository;
    }


    /**
     * @param [] $data
     * @return null|SubType[]
     */
    public function save($data)
    {
        $subtypes = $data["subtype"];
        $subtypesList = [];

        foreach ($subtypes as $key => $keywords) {
            $subType = $this->save2($keywords['keyword'], $keywords['aliases'] );
            if ( $subType ){
                $subtypesList[] = $subType;
            }
        }
        return count($subtypesList) > 0 ? $subtypesList: null;
    }

    /**
     * @param $name
     * @param $aliases
     * @return null|SubType
     */
    public function save2( $name, $aliases ) {
        $keyword = $this->saveKeyword(6, $name, $aliases );

        $subType = $this->subTypeRepository->findByName($name);
        if( !$subType ) {
            $subType = new SubType();
            $subType->setName($name);
            $subType->setKId($keyword->getId());
            $subType->setId($this->subTypeRepository->save($subType));
        }
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
        //return $this->subTypeRepository->fetch();
    }
    /**
     * @param $id
     * @return SubType $subType|null
     */
    public function findById($id)
    {
        //return $this->subTypeRepository->findById($id);
    }
    /**
     * @param \Prestation\Entity\SubType $subType
     * @return mixed
     */
    public function update($subType)
    {


    }

}