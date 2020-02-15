<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 21:24
 */

namespace Prestation\Repository;


use Prestation\Entity\Entreprise;

interface EntrepriseRepository extends RepositoryInterface
{
    /**
     * @param Entreprise $entreprise
     * @return int|null
     */
    public function create($entreprise);

    /**
     * @param $name
     * @return Entreprise|null
     */
    public function findByName($name);

    /**
     * @param $user_id
     * @return Entreprise|null
     */
    public function fetchByUserId($user_id);
}