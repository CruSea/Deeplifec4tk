<?php

namespace SamUser\Form;

use Zend\Form\Form;

class ChangePassword extends Form
{
    private $translator;

    public function __construct($name = null, $options = array())
    {
        parent::__construct('change-password');

    }

    public function init()
    {
        // We always want to use POST method with this form
        $this->setAttribute('method', 'post');
        $this->setAttribute('data-ng-submit', 'savePassword()');

        // Add fields to this form
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'data-ng-model' => 'passwordForm.id',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'class' => 'form-control',
                'data-ng-model' => 'passwordForm.password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'passwordConfirm',
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'class' => 'form-control',
                'data-ng-model' => 'passwordForm.passwordConfirm',
            ),
            'options' => array(
                'label' => 'Confirm',
            ),
        ));

        $actions = new \Zend\Form\Fieldset('actions');
        $actions->add(array(
            'name' => 'close',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Close',
                'class' => 'btn btn-default form-control',
                'data-dismiss' => "modal"
            )
        ));
        $actions->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-primary form-control'
            )
        ));

        $this->add($actions);
    }
}
