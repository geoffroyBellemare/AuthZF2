<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/10/2018
 * Time: 17:10
 */

namespace Prestation\Service;


use Prestation\Entity\AgeCategory;

class AgeCategoryServiceImpl implements AgeCategoryService
{

    /**
     * @var \Prestation\Repository\AgeCategoryRepository
     */
    public $ageCategoryRepository;

    /**
     * AgeCategoryServiceImpl constructor.
     * @param \Prestation\Repository\AgeCategoryRepository $ageCategoryRepository
     */
    public function __construct(\Prestation\Repository\AgeCategoryRepository $ageCategoryRepository)
    {
        $this->ageCategoryRepository = $ageCategoryRepository;
    }


    /**
     * @param $data
     * @return null|\Prestation\Entity\AgeCategory[]
     */
    public function save($data)
    {
        $ages = [];
        foreach ($data['ages'] as $value) {
            $recordedAgeCategory = $this->ageCategoryRepository->findByName($value['name']);

            if( !$recordedAgeCategory ) {

                $ageCategory = new AgeCategory();
                $ageCategory->setName($value['name']);
                $ageCategory->setId($this->ageCategoryRepository->create($ageCategory));
                $ages[] = $ageCategory;

            } else {

                $ages[] = $recordedAgeCategory;

            }



        }
       return  count($ages)  ? $ages: null;
    }
}