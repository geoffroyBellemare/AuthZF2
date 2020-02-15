<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 23/07/2018
 * Time: 14:25
 */

namespace Prestation\Controller;




use Prestation\Service\PrestationServiceImpl;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;


class PrestationRestController extends AbstractRestfulController
{
    protected $collectionMethod = array('GET');
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');

    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkMethod'), 10);
    }
    public function get($id)
    {
        $this->options();
        $action = $this->params()->fromRoute('slug');

        return new JsonModel([$action,$id]);
    }
    public function getList()
    {
        $this->options();
        $this->response->setStatusCode(200);
        $service = $this->getPrestationService();
        $service->save();
        $variables = array();
        $action = $this->params()->fromRoute('slug');
        $variables['data'] = $action;

        return new JsonModel($variables);

    }
    protected function _getMethod() {
        if (1/*$this->params()->fromRoute('slug', false)*/){
            return $this->ressourceMethod;
        }
        return $this->collectionMethod;
    }

    public function checkMethod($e) {
        if (in_array($e->getRequest()->getMethod(), $this->_getMethod())){
            return;
        }
        $response = $this->getResponse();
        $response->setStatusCode(405);
        return $response;
    }

    public function options() {
        $response = $this->getResponse();
        $response->getHeaders()
            ->addHeaderLine('Allow', implode(',', $this->_getMethod()))
            ->addHeaderLine('Access-Control-Allow-Origin','*')
            //set allow methods
            ->addHeaderLine('Access-Control-Allow-Methods',$this->_getMethod());
        return $response;
    }


    public function create($data)
    {

        $this->options();
        $this->response->setStatusCode(400);
        $action = $this->params()->fromRoute('slug');
        $variables = array();


        switch($action) {
            default:
                $variables['data'] = null;
        }
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
    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }

    public function delete($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__.' delete current data with id =  '.$id) ;
        return $response;
    }


    /**
     * @return PrestationServiceImpl $prestationService
     */
    protected function getPrestationService() {
        return $this->getServiceLocator()->get('Prestation\Service\PrestationService');
    }
    // configure response
    public function getResponseWithHeader()
    {
        $response = $this->getResponse();
        $response->getHeaders()
            //make can accessed by *
            ->addHeaderLine('Access-Control-Allow-Origin','*')
            //set allow methods
            ->addHeaderLine('Access-Control-Allow-Methods','POST PUT DELETE GET');

        return $response;
    }


}