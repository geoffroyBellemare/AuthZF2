<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 21:20
 */

namespace Prestation\Service;


class VendreServiceImpl implements VendreService
{
    /**
     * @var \Prestation\Repository\VendreRepository
     */
    protected $vendreRepo;
    /**
     * @var \Prestation\Repository\EntrepriseRepository
     */
    protected $entrepriseRepo;
    /**
     * @var \Prestation\Repository\ReservationRepository
     */
    protected $reservationRepo;

    /**
     * VendreServiceImpl constructor.
     * @param \Prestation\Repository\VendreRepository $vendreRepo
     * @param \Prestation\Repository\EntrepriseRepository $entrepriseRepo
     * @param \Prestation\Repository\ReservationRepository $reservationRepo
     */
    public function __construct(\Prestation\Repository\VendreRepository $vendreRepo, \Prestation\Repository\EntrepriseRepository $entrepriseRepo)
    {
        $this->vendreRepo = $vendreRepo;
        $this->entrepriseRepo = $entrepriseRepo;
    }


    public function create($entreprise, $prestation, $hebergeur, $period)
    {
        // TODO: Implement create() method.

        //en type spot prestation acceuil
        //$this->reservationRepo->create($entreprise, )
        $this->vendreRepo->create($entreprise, $prestation, $hebergeur, $period);

    }


    public function isEntreprise($user_id)
    {
        // TODO: Implement isEntreprise() method.
    }

    public function isPrestataireFree($user_id)
    {
        // TODO: Implement isPrestataireFree() method.
    }

    public function isHostFree($p_id)
    {
        // TODO: Implement isHostFree() method.
    }

    public function isHostOpen($p_id)
    {
        // TODO: Implement isHostOpen() method.
    }

}