<?php
/**
 * Created by PhpStorm.
 * User: briggsm
 * Date: 9/1/16
 * Time: 1:11 PM
 */

namespace LandingPage\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction() {
        $this->layout("layout/generic");
        return new ViewModel();
    }

    public function seaAction() {
        $this->layout("layout/sea");
        return new ViewModel();
    }

    public function pactAction() {
        $this->layout("layout/pact");
        return new ViewModel();
    }

    public function eeAction() {
        $this->layout("layout/ee");
        return new ViewModel();
    }

    public function otherAction() {
        $this->layout("layout/other");
        return new ViewModel();
    }
}