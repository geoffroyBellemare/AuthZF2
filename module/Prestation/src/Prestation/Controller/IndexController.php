<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 14/05/2019
 * Time: 23:35
 */

namespace Prestation\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends  AbstractActionController
{

    public function indexAction(){
        return new ViewModel();
    }
}