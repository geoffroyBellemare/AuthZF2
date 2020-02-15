<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 16:33
 */

namespace Prestation\Service;


use Prestation\Entity\Country;
use Prestation\Validator\EntityExistValidator;

class CountryServiceImpl implements CountryService
{

    public $adapter;
    /**
     * @var \Prestation\Repository\CountryRepository
     */
    public $countryRepository;

    /**
     * @var \Prestation\Service\KeywordServiceImpl
     */
    public $keywordService;

    /**
     * CountryServiceImpl constructor.
     * @param $adapter
     * @param \Prestation\Repository\CountryRepository $countryRepository
     * @param KeywordServiceImpl $keywordService
     */
    public function __construct($adapter, \Prestation\Repository\CountryRepository $countryRepository, KeywordServiceImpl $keywordService)
    {
        $this->adapter = $adapter;
        $this->countryRepository = $countryRepository;
        $this->keywordService = $keywordService;
    }


    /**
     * @param array $data
     * @return \Prestation\Entity\Country
     */
    public function save($data)
    {
        $country = $this->countryRepository->findByName($data['name']);
        if (!$country) {
            $country = new Country();
            $country->setName($data['country']);
            $country->setCode($data['country_code']);
            $country->setId($this->countryRepository->create($country));

        }

        return $country;
    }

    /**
     * @param array $data
     * @return \Prestation\Entity\Country|null
     */
    public function saveFromBackup($data)
    {
        $keyword = $this->keywordService->save(1, $data['country'], []);

        $country = $this->countryRepository->findByName($data['country']);
        if(!$country) {
            $country = new Country();
            $country->setName($data['country']);
            $country->setCode($data['country_code']);
            $country->setKId($keyword->getId());
            $country->setId($this->countryRepository->create($country));
        }
/*        try {
            $country = new Country();
            $country->setName($data['country']);
            $country->setCode($data['country_code']);
            $country->setKId($keyword->getId());
            $country->setId($this->countryRepository->create($country));
        } catch (\Exception $e ) {
            $country = $this->countryRepository->findByName($data['country']);
        }*/

        return $country;
    }
}