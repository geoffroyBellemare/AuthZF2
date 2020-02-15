<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/07/2019
 * Time: 13:44
 */

namespace Reservation\Controller;


use Prestation\Controller\PrestationRestFullController;

use Prestation\Validator\PrestationIsOpenValidator;
use Zend\View\Model\JsonModel;

class ReservationController extends PrestationRestFullController
{
    /**
     * @var \Prestation\Service\ReservationService
     */
    protected $reservationService;
    /**
     * @var \Prestation\Validator\PrestationIsOpenValidator
     */
    protected $prestationIsOpenValidator;
    protected $collectionMethod = array('GET');
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');

    /**
     * ReservationController constructor.
     * @param \Prestation\Service\ReservationService $reservationService
     */
    public function __construct(\Prestation\Service\PrestationService $prestationService, \Prestation\Service\ReservationService $reservationService, \Prestation\Validator\PrestationIsOpenValidator $prestationIsOpenValidator)
    {
        parent::__construct($prestationService);
        $this->reservationService = $reservationService;
        $this->prestationIsOpenValidator = $prestationIsOpenValidator;
    }

    public function get($id)
    {
        $this->options();
        $action = $this->params()->fromRoute('slug');
        //route: api/controller/type?id=45
        return new JsonModel([$action,$id]);
    }

    public function getList()
    {

        $this->options();
        $this->response->setStatusCode(200);

        $variables = array();
        $action = $this->params()->fromRoute('slug');

         $variables['data'] = 'slut reservation';

        return new JsonModel($variables);

    }


    public function create($data)
    {
        $this->options();
        $variables = array();

        $this->response->setStatusCode(200);
        if($this->prestationIsOpenValidator->isValid($data)) {

        } else {
            $variables['error'] = $this->prestationIsOpenValidator->getMessages();
        }



        //$action = $this->params()->fromRoute('slug');

        //       $validatorMarker = new MarkerValidator($optionsValidator);
        //$validatorHoraires = new HoraireValidator();
        /*        if ($this->horaireValidator->isValid($data)) {
                    var_dump('oki');
                } else {
                    var_dump($this->horaireValidator->getMessages());
                }*/
        // $validatorHoraires->isValid($data);
        /*$validatorMarker->isValid($data)*/
        /*        if ( 1  ) {
                    $variables['data'] = $this->prestationService->save($data);
                } else {
                    $variables['data'] = $validatorMarker->getMessages();
                    $this->response->setStatusCode(406);
                }*/
        $testData = ['p_id' => ''];

            $variables['data'] = $data;


        return new JsonModel($variables);

    }

    public function update($id, $data)
    {
        $this->options();
        $action = $this->params()->fromRoute('slug');
        $variables = array();

        $variables['data'] = $data;
        return new JsonModel($variables['data']);
    }


    public function delete($id)
    {
        $this->options();
        $action = $this->params()->fromRoute('slug');
        $variables = array();

        $variables['data'] = ['potentielement une erreur'];
        return new JsonModel($variables['data']);

    }

}