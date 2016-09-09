<?php
namespace Messaging\Form;

use Zend\Form\Form;

class MessagingForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('messaging');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'sender_id',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'token',
            ),
            'options' => array(
                'label' => 'To',
            ),
        ));
        $this->add(array(
            'name' => 'subject',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Subject',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'required' => 'required',
                'id' => 'description'
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Send',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary pull-right',
            ),
        ));
    }


}