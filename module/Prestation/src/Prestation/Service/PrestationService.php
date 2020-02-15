<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 16/05/2019
 * Time: 15:17
 */

namespace Prestation\Service;

use Prestation\Entity\Prestation;

interface PrestationService
{
    /**
     * @param $data
     * @return mixed
     */
    public function share($data);
    /**
     * @param $data
     * @return mixed
     */
    public function isFree($data);

    /**
     * @param [] $date
     * @return mixed
     */
    public function save($data);

    /**
     * @param Prestation $prestation
     * @return mixed
     */
    public  function update(Prestation $prestation);
    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page);

    /**
     * @return array
     */
    public  function fetchAll();

    /**
     * @param $id
     * @return Prestation|null
     */
    public function findById($id);

    /**
     * @param $id
     * @return void
     */
    public function delete($id);
}