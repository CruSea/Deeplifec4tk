<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    
    // add disciple
    Public function contactusAction()
    {
              die('sdgfsdgsdgsdgsdgsdgsdgsdgsd');
    }
    
    
    // add disciple
    Public function indexAction()
    {
        
      
        $view = new ViewModel(array(
            'imageurl' => '',
            'Url' => '/',
            'title' => 'Add Disciples',
        ));
        return $view;
    }
//    userdashboard
    Public function userdashboardAction()
    {
        $view = new ViewModel(array(
            'Url' => '/',
            'title' => 'User Dashboard',
        ));
        return $view;
    }

    //list disciples
    Public function listdiscipleAction()
    {
        $view = new ViewModel(array(
            'Url' => '/',
            'title' => 'Your Disciples',
        ));
        return $view;
    }

    //update user info
    Public function updateinfoAction()
    {
        $view = new ViewModel(array(
            'Url' => '/',
            'title' => 'Update Your Information',
        ));
        return $view;
    }
}
