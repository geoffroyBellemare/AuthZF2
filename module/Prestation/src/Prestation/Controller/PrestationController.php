<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 23/07/2018
 * Time: 14:25
 */

namespace Prestation\Controller;




use Prestation\Service\PrestationServiceImpl;
use Prestation\Validator\HoraireValidator;
use Prestation\Validator\MarkerLatLngNoRecordExist;
use Prestation\Validator\MarkerValidator;
use Prestation\Validator\ReservationValidator;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;


class PrestationController extends PrestationRestFullController
{

    protected $collectionMethod = array('GET');
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');
    /**
     * @var \Prestation\Service\PrestationService
     */
    protected $prestationService;
    /**
     * @var \Prestation\Validator\HoraireValidator
     */
    protected $horaireValidator;
    /**
     * @var \Prestation\Validator\ReservationValidator
     */
    protected $reservationValidator;

    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $adapter;



    public $dataCrash = array(
        "country" => "france",
        "country_code" => "FR",
        "department" => "Normandie",
        "region" => "Normandie",
        "locality" => "Rouen",
        "postcode" => "76000",
        "lat" => 43.698204,
        "lng" => 0.268103
    );

    /**
     * PrestationController constructor.
     * @param \Prestation\Service\PrestationService $prestationService
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(\Prestation\Service\PrestationService $prestationService, HoraireValidator $horaireValidator, ReservationValidator $reservationValidator, \Zend\Db\Adapter\Adapter $adapter)
    {
        parent::__construct($prestationService);
        $this->prestationService = $prestationService;
        $this->horaireValidator = $horaireValidator;
        $this->reservationValidator = $reservationValidator;
        $this->adapter = $adapter;
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
        $this->prestationService->save($this->dataCrash);
       // $variables['data'] = $this->prestationService->save($this->dataCrash);

        return new JsonModel($variables);

    }


    public function create($data)
    {
        $this->options();
        $this->response->setStatusCode(200);
        $variables = array();
        $optionsValidator = array(
            'adapter' => $this->adapter,
            'field' => '',
            'table' => ''
        );
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
/*        if ($this->reservationValidator->isValid($data)) {
            $variables['data'] = $this->prestationService->create($data);
        } else {
            var_dump($this->reservationValidator->getMessages());
            $variables['errors'] = $this->reservationValidator->getMessages();
        }*/

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
        $this->prestationService->delete($id);
        $variables['data'] = ['potentielement une erreur'];
        return new JsonModel($variables['data']);

    }


}