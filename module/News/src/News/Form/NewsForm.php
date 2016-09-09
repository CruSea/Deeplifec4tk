<?php
namespace News\Form;

use Zend\Form\Form;

class NewsForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('news');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));


        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'rows' => "4",
                'cols' => "50",
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Description',
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
                'id' => 'multicountry',
                'class' => 'form-control',
                'multiple' => 'multiple',
                'required' => 'required',


            ),
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                'label' => 'Status',

                'value_options' => array(
                    0 => 'WAITING',
                    1 => 'APPROVED',
                    2 => 'REJECTED'
                ),

            ),


            'attributes' => array(
                'id' => 'status',
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'id' => 'image',
                'type' => 'File',
                'class' => 'form-control',

            ),
            'options' => array(
                'label' => 'Image',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary pull-right',
            ),
        ));
    }


}