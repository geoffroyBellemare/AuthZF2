<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/05/2019
 * Time: 20:42
 */

namespace Prestation\Service;


interface PrestataireService
{
    /**
     * @param $pvr_id
     * @param $date
     * @return mixed
     */
    public function isFree($pvr_id, $date);

    /**
     * @param []$data
     * @return mixed
     */
    public function isHostFree($data);

    /**
     * @param $data
     * @return mixed
     */
    public function isHostOpen($data);
}