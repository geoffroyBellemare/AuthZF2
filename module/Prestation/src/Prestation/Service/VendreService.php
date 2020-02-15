<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 21:16
 */

namespace Prestation\Service;


interface VendreService
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($entreprise, $prestation, $spot, $period);
    public function isEntreprise($user_id);
    public function isPrestataireFree($user_id);
    public function isHostFree($p_id);
    public function isHostOpen($p_id);
}