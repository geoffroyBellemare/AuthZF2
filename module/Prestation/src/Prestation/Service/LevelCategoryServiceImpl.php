<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/10/2018
 * Time: 14:03
 */

namespace Prestation\Service;


use Prestation\Entity\LevelCategory;

class LevelCategoryServiceImpl implements LevelCategoryService
{

    /**
     * @var \Prestation\Repository\LevelCategoryRepository
     */
    public $levelCategoryRepository;

    /**
     * LevelCategoryServiceImpl constructor.
     * @param \Prestation\Repository\LevelCategoryRepository $levelCategoryRepository
     */
    public function __construct(\Prestation\Repository\LevelCategoryRepository $levelCategoryRepository)
    {
        $this->levelCategoryRepository = $levelCategoryRepository;
    }


    /**
     * @param array
     * @return \Prestation\Entity\LevelCategory[]|null
     */
    public function save($data)
    {
        $levelCategoryList = [];
        foreach ($data['levels'] as $level) {

           $recordedLevelCategory = $this->levelCategoryRepository->findByName($level['name']);

            if(!$recordedLevelCategory) {
                $levelCategory = new LevelCategory();
                $levelCategory->setName($level['name']);
                $levelCategory->setId($this->levelCategoryRepository->create($levelCategory));
                $levelCategoryList[] = $levelCategory;

            } else {
                $levelCategoryList[] = $recordedLevelCategory;
            }

        }
        return count($levelCategoryList) > 0 ? $levelCategoryList : null;
    }
}