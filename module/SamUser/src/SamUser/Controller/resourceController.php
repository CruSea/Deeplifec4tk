<?php
/**
 * Created by PhpStorm.
 * User: Fre
 * Date: 11/7/2015
 * Time: 8:07 AM
 */

namespace SamUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ResourceController  extends AbstractActionController
{
    Public function indexAction()
    {
//
        $view = new ViewModel(array(
            'Url' => '/winresource',
            'title' => 'resources',

        ));
        return $view;

    }


    Public function download1Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 1.docx"');
        readfile('img/resource/Book 1.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    Public function download2Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 2.docx"');
        readfile('img/resource/Book 2.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    Public function download3Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 3.docx"');
        readfile('img/resource/Book 3.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    Public function download4Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 4.docx"');
        readfile('img/resource/Book 4.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    Public function download5Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 5.docx"');
        readfile('img/resource/Book 5.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }
    Public function download6Action()
    {
//        if (userHasNoPermissions) {
//            $this->view->msg = 'This file cannot be downloaded!';
//            $this->_forward('error', 'download');
//            return FALSE;
//        }

        header('Content-Type: word/.docx');
        header('Content-Disposition: attachment; filename="Book 6.docx"');
        readfile('img/resource/Book 6.docx');

        // disable the view ... and perhaps the layout
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

    }

    Public function errorAction()
    {

    }


}