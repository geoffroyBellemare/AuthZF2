<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 20/05/2019
 * Time: 14:24
 */

namespace Prestation\Controller;


use Prestation\Service\PrestationServiceImpl;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class PrestationRestFullController extends AbstractRestfulController
{

    protected $collectionMethod = array('GET');
    protected $ressourceMethod = array('GET', 'POST', 'PUT', 'DELETE');
    /**
     * @var \Prestation\Service\PrestationService
     */
    protected $prestationService;

    public function __construct(\Prestation\Service\PrestationService $prestationService)
    {
        $this->prestationService = $prestationService;
    }


    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkMethod'), 10);
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
    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
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