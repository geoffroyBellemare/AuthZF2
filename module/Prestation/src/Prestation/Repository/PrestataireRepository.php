<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 19:27
 */

namespace Prestation\Repository;


interface PrestataireRepository extends RepositoryInterface
{
    /**
     * @param \Prestation\Entity\Prestataire $provider
     * @param \Prestation\Entity\Horaire $horaire
     * @param \Prestation\Entity\Period $period
     * @return true|false
     */
    public function isFree($provider, $horaire, $period);

    /**
     * @param []$period
     * @param []$horaire
     * @return false|mixed
     */
    public function isHostFree($period, $horaire);

    /**
     * @param []$period
     * @param []$horaire
     * @return false|mixed
     */
    public function isHostOpen($period, $horaire);
}