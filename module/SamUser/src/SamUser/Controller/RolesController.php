<?php

namespace SamUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RolesController extends AbstractActionController
{
    public function indexAction()
    {
        $createForm = $this->getServiceLocator()->get('EntityForm')->getForm('SamUser\Entity\Role', 'create()');

        return array(
            'form' => $createForm,
        );
    }

    public function detailsAction()
    {
        return array();
    }
}
