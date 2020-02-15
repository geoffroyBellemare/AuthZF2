<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/10/2018
 * Time: 16:18
 */

namespace Prestation\Service;


use Prestation\Entity\Departement;

class DepartementServiceImpl implements DepartementService
{
    public $adapter;
    /**
     * @var \Prestation\Repository\DepartementRepository
     */
    public $departementRepository;
    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    public $keywordService;

    /**
     * DepartementServiceImpl constructor.
     * @param $adapter
     * @param \Prestation\Repository\DepartementRepository $departementRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct($adapter, \Prestation\Repository\DepartementRepository $departementRepository, KeywordServiceImpl $keywordService)
    {
        $this->adapter = $adapter;
        $this->departementRepository = $departementRepository;
        $this->keywordService = $keywordService;
    }


    /**
     * @param $data
     * @return \Prestation\Entity\Departement
     */
    public function save($data)
    {
        $departement = $this->departementRepository->findByName($data['departement']);
        if(!$departement) {
            $departement = new Departement();
            $departement->setName($data['departement']);
            $departement->setId($this->departementRepository->create($departement));
        }
        return $departement;
    }

    public function saveRelation($departement, $marker) {
        $relation = $this->departementRepository->findRelation($departement, $marker);

        if( !$relation ) {
            $this->departementRepository->createRelation($departement, $marker);
        }

    }

    /**
     * @param $data
     * @param $marker
     * @return null|Departement
     */
    public  function saveFromBackup($data, $marker) {

        if( !isset($data["administrative_area_level_2"]) ) return null;
        $keyword = $this->keywordService->save(3, $data["administrative_area_level_2"], []);

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
