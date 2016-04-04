<?php

namespace SamUser\Controller;

use Zend\Validator\ValidatorChain;
use DoctrineModule\Validator\ObjectExists;
use Zend\Mvc\Controller\AbstractActionController;

class UsersController extends AbstractActionController
{
    protected $em;

    protected function getEntityManager() {
        if (null === $this->em)
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $this->em;
    }

    protected function filterParent($var) {
        return !$var->getParent();
    }

    protected function filterChild($var) {
        return $var->getParent();
    }

    /**
     * User list / default action
     */
    public function indexAction() {
        
          

        // TODO: We need support for deeper children
        $roles = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll();
        $parents = array_filter($roles, array($this, "filterParent"));
        $childs = array_filter($roles, array($this, "filterChild"));

        // Service locator
        $sl = $this->getServiceLocator();

        // Create form
        $createForm = $sl->get('EntityForm')->getForm('SamUser\Entity\User', 'create()');
        $createForm = $sl->get('EntityForm')->getForm('SamUser\Entity\User', 'register()');

        // Change password form
        $changePasswordForm = $sl->get('FormElementManager')->get(
            'SamUser\Form\ChangePassword',
            array('name' => 'change-password')
        );

        return array(
            'rolesParent' => $parents,
            'rolesChild' => $childs,
            'form' => $createForm,
            'changePasswordForm' => $changePasswordForm,
        );
    }

    /**
     * User details
     */
    public function detailsAction() {
        // TODO: We need support for deeper children
        $roles = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll();
        $parents = array_filter($roles, array($this, "filterParent"));
        $childs = array_filter($roles, array($this, "filterChild"));

        return array(
            'rolesParent' => $parents,
            'rolesChild' => $childs,
        );
    }
}
