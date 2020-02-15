<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 12/10/2018
 * Time: 16:33
 */

namespace Prestation\Service;


use Prestation\Entity\Country;

class CountryServiceImpl extends KeywordServiceImpl2 implements CountryService
{
    /**
     * @var \Prestation\Repository\CountryRepository
     */
    public $countryRepository;

    /**
     * CountryServiceImpl constructor.
     * @param \Prestation\Repository\CountryRepository $countryRepository
     * @param \Prestation\Repository\KeywordRepository $keywordRepository
     * @param \Prestation\Repository\AliasesRepository $aliasesRepository
     */
    public function __construct(\Prestation\Repository\CountryRepository $countryRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->countryRepository = $countryRepository;

    }

    /**
     * @param array $data
     * @return \Prestation\Entity\Country
     */
    public function save($data)
    {
        $keyword = $this->saveKeyword(1, $data['country'], []);

        $country = $this->countryRepository->findByName($data['country']);
        if(!$country) {
            $country = new Country();
            $country->setName($data['country']);
            $country->setCode($data['country_code']);
            $country->setKId($keyword->getId());
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