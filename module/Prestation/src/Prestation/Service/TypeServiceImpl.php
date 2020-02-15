<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 14:51
 */

namespace Prestation\Service;


use Prestation\Entity\Type;

class TypeServiceImpl extends KeywordServiceImpl2 implements TypeService
{
    /**
     * @var \Prestation\Repository\TypeRepository
     */
    public $typeRepository;


    /**
     * TypeServiceImpl constructor.
     * @param \Prestation\Repository\TypeRepository $typeRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct(\Prestation\Repository\TypeRepository $typeRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->typeRepository = $typeRepository;
    }


    /**
     * @param array $data
     * @return Type|null
     */
    public function save($data)
    {
        $keyword = $this->saveKeyword(5, $data['name'], $data['aliases']);
        $type = $this->typeRepository->findByName($data['name']);
        if( !$type ) {
            $type = new Type();
            $type->setKId($keyword->getId());
            $type->setName($data['name']);
            $type->setId($this->typeRepository->create($type));
        }
        return $type;
    }

    /**
     * @param $data
     * @return Type|null
     */
    public function saveFromBackup($data) {
            $keyword = $this->saveKeyword(5, $data['type'], $data['aliases']);
        $type = $this->typeRepository->findByName($data['type']);
        if( !$type ) {
            $type = new Type();
            $type->setKId($keyword->getId());
            $type->setName($data['type']);
            $type->setId($this->typeRepository->create($type));
        }
/*            $type = new Type();
            $type->setKId($keyword->getId());
            $type->setName($data['type']);
            $type->setId($this->typeRepository->create($type));

            if( !$type->getId() ) {
                $type = $this->typeRepository->findByName($data['type']);
            }*/
            return $type;
    }
}