<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/06/2019
 * Time: 12:52
 */

namespace Prestation\Service;


use Prestation\Entity\SportCategory;
use Prestation\Repository\SportCategoryRepository;

class SportCategoryServiceImpl extends KeywordServiceImpl2 implements CRUDInterface
{
    /**
     * @var \Prestation\Repository\SportsCategoryRepositoryImpl
     */
    protected $sportCategoryRepository;


    public function __construct(SportCategoryRepository $sportCategoryRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->sportCategoryRepository = $sportCategoryRepository;

    }
    /**
     * @param $data
     * @return []SportCategory|null
     */
    public function save($data)
    {
        $sports = [];
        foreach ( $data['sports'] as $key => $values) {
            $keyword = $this->saveKeyword(8, $values['name'], $values['aliases']);
            $sport = $this->sportCategoryRepository->findByName($values['name']);
            if( !$sport ) {
                $sport = new SportCategory();
                $sport->setName($values['name']);
                $sport->setKId($keyword->getId());
                $sport->setId($this->sportCategoryRepository->save($sport));
            }
            if($sport->getId())$sports[] = $sport;
        }
        return count($sports) > 0 ? $sports: null;
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchById($id)
    {
        // TODO: Implement fetchById() method.
    }

    /**
     * @return []mixed
     */
    public function fetchAll()
    {
        // TODO: Implement fetchAll() method.
    }
}