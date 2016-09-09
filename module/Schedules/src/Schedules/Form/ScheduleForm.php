<?php
namespace Schedules\Form;

use Zend\Form\Form;

class ScheduleForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'userdetail',
            'type' => 'Select',
            'options' => array(
                'label' => 'Person name',
                'empty_option' => 'Select Disciple',
                'value_options' => array(),

            ), 'attributes' => array(
                'id' => 'userdetail',
                'class' => 'form-control',
                'required' => 'required',


            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Textarea',
                'class' => 'form-control',
                'rows' => '5',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));


        $this->add(array(
            'name' => 'txtdate',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control date ',
                'id' => 'datetimepicker11',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Date',
            ),
        ));

        $this->add(array(
            'name' => 'txttime',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control date',
                'id' => 'datetimepicker12',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Time',
            ),
        ));

        $this->add(array(
            'name' => 'recurring',
            'type' => 'Select',
            'options' => array(
                'label' => 'Repeat',
                'value_options' => array(
                    '0' => 'Only once',
                    '1' => 'Weekly',
                    '2' => 'Monthly',
                ),

            ), 'attributes' => array(
                'id' => 'repeat',
                'class' => 'form-control',
                'required' => 'required',


            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}