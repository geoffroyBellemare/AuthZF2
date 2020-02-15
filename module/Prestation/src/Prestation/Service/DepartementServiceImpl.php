<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 16:18
 */

namespace Prestation\Service;


use Prestation\Entity\Departement;

class DepartementServiceImpl extends KeywordServiceImpl2 implements DepartementService
{

    /**
     * @var \Prestation\Repository\DepartementRepository
     */
    public $departementRepository;


    /**
     * DepartementServiceImpl constructor.
     * @param $adapter
     * @param \Prestation\Repository\DepartementRepository $departementRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct(\Prestation\Repository\DepartementRepository $departementRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->departementRepository = $departementRepository;
    }


    /**
     * @param $data
     * @return \Prestation\Entity\Departement
     */
    public function save($data)
    {
        if( !isset($data["department"]) ) return null;
        $keyword = $this->saveKeyword(3, $data["department"], []);

        $department = $this->departementRepository->findByName($data["department"]);
        if( !$department ) {
            $departement = new Departement();
            $departement->setKId($keyword->getId());
            $departement->setName($data["department"]);
            $departement->setId($this->departementRepository->create($departement));
        }


        return $department;
    }

    /**
     * @param $data
     * @param $marker
     * @return null|Departement
     */
    public  function saveFromBackup($data, $marker) {

        if( !isset($data["administrative_area_level_2"]) ) return null;
        $keyword = $this->saveKeyword(3, $data["administrative_area_level_2"], []);

        $department = $this->departementRepository->findByName($data["administrative_area_level_2"]);
        if( !$department ) {
            $departement = new Departement();
            $departement->setKId($keyword->getId());
            $departement->setName($data["administrative_area_level_2"]);
            $departement->setId($this->departementRepository->create($departement));
        }

/*        $departement = new Departement();
        $departement->setKId($keyword->getId());
        $departement->setName($data["administrative_area_level_2"]);
        $departement->setId($this->departementRepository->create($departement));


        if( !$departement->getId() ) {
            $department = $this->departementRepository->findByName($data["administrative_area_level_2"]);

        }*/

        if( $department ) {
            $this->departementRepository->createRelation($department, $marker);
        }

        return $department;
    }
}
