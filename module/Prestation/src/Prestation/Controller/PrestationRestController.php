<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 15/05/2019
 * Time: 10:47
 */

namespace Prestation\Controller;


use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PrestationRestController extends AbstractRestfulController
{
    protected $collectionMethod = array('GET');
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');

    public function get($id)
    {
        $variables = array();
        $this->options();
        $variables['data'] = "get test";
        return new JsonModel($variables);
    }

    public function getList()
    {
        $this->options();
        $variables = array();
        $variables['data'] = "test de list";
        return new JsonModel($variables);
    }


    public function create($data) {

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

    public function update($id, $data) {

        $this->options();
        $action = $this->params()->fromRoute('slug');
        $variables = array();

        switch($action) {
            default:
                $variables['data'] = $data;
        }
        return new JsonModel($variables['data']);
    }

    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkMethod'), 10);
    }

    protected function _getMethod() {
        if ($this->params()->fromRoute('slug', false)){
            return $this->ressourceMethod;
        }
        return $this->collectionMethod;
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
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
}