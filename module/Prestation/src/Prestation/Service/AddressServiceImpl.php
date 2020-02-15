<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/06/2019
 * Time: 01:51
 */

namespace Prestation\Service;


use Prestation\Entity\Address;

class AddressServiceImpl extends KeywordServiceImpl2 implements AddressService
{
    /**
     * @var \Prestation\Repository\AddressRepositoryImpl
     */
    public $addressRepository;

    public function __construct(\Prestation\Repository\AddressRepositoryImpl $addressRepository, \Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        parent::__construct($keywordRepository, $aliasesRepository);
        $this->addressRepository = $addressRepository;

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

    /**
     * @param $data
     * @param $l_id
     * @param $c_id
     * @param $d_id
     * @param $r_id
     * @return mixed|null
     */
    public function save($data, $l_id, $c_id, $d_id, $r_id)
    {
        $keyword = $this->saveKeyword(9, $data['address'], []);
        $address = $this->addressRepository->findByName($data['address']);

        if ( !$address ) {
            $address = new Address();
            $address->setName($data['address']);
            $address->setKId($keyword->getId());
            $address->setLId($l_id);
            $address->setCId($c_id);
            if($d_id) $address->setDId($d_id);
            if($r_id) $address->setRId($r_id);
            $address->setId($this->addressRepository->create($address));
        }

        return $address->getId() ? $address: null;
    }
}