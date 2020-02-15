<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 11/10/2018
 * Time: 14:03
 */

namespace Prestation\Repository;


use Prestation\Repository\RepositoryInterface;

interface CountryRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Country $country
     * @return mixed
     */
    public function create($country);
    /**
     * @param $id
     * @return \Prestation\Entity\Country|null
     */
    public function findById($id);

    /**
     * @param $name
     * @return \Prestation\Entity\Country|null
     */
    public function findByName($name);
    /**
     * @param \Prestation\Entity\Country $country
     * @return mixed
     */
    public function update($country);


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}