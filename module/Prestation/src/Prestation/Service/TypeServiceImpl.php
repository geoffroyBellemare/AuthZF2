<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 19/10/2018
 * Time: 14:51
 */

namespace Prestation\Service;


use Prestation\Entity\Type;

class TypeServiceImpl implements TypeService
{
    /**
     * @var \Prestation\Repository\TypeRepository
     */
    public $typeRepository;
    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    public $keywordService;

    /**
     * TypeServiceImpl constructor.
     * @param \Prestation\Repository\TypeRepository $typeRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct(\Prestation\Repository\TypeRepository $typeRepository, KeywordServiceImpl $keywordService)
    {
        $this->typeRepository = $typeRepository;
        $this->keywordService = $keywordService;
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function save($data)
    {
        $type = $this->hydrate($data['type']);
        $recordedType = $this->typeRepository->findByName($data['type']['name']);


       if( !$recordedType ) {
            $type->setId($this->typeRepository->create($type));
        } else {
            $type = $recordedType;
        }
        return $type;
    }

    /**
     * @param $data
     * @return Type|null
     */
    public function saveFromBackup($data) {
            $keyword = $this->keywordService->save(5, $data['type'], $data['aliases']);
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
    /**
     * @param $data
     * @return Type
     */
    private function hydrate($data) {
        $type = new Type();
        $type->setId( isset($data['id'])? $data['id']: null );
        $type->setName( isset($data['name'])? $data['name']: null);
        return $type;

    }
}