<?php
namespace Share\Form;

use Zend\Form\Form;

class QuestionForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('ishares');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'question',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Question',
            ),
        ));


        $this->add(array(
            'name' => 'category',
            'type' => 'Select',
            'options' => array(
                'label' => 'Category',

                'value_options' => array(
                    'WIN' => 'WIN',
                    'BUILD' => 'BUILD',
                    'SEND' => 'SEND',
                ),

            ),


            'attributes' => array(
                'id' => 'category',
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));


        $this->add(array(
            'name' => 'country',
            'type' => 'Select',
            'options' => array(
                'label' => 'Country',
                'value_options' => array(
                    '1' => 'India',

                ),
            ), 'attributes' => array(
                'id' => 'country',
                'class' => 'form-control',
                'required' => 'required',


            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}