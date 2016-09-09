<?php
namespace SamUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class RegisterForm extends Form
{

    protected $inputFilter;

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('Application');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));


        $this->add(array(
            'name' => 'firstName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',

            ), 'attributes' => array(
                'id' => 'firstName',
                'class' => 'form-control',

            ),
        ));


        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'id' => 'email',
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id' => 'Password',
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
            'name' => 'phone_no',
            'type' => 'Text',
            'options' => array(
                'label' => 'Phone',

            ), 'attributes' => array(
                'id' => 'phone_no',
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));


        $this->add(array(
            'name' => 'gender',
            'type' => 'Select',
            'options' => array(
                'label' => 'Gender',
                'id' => 'gender',
                'class' => 'form-control',
                'required' => 'required',
                'value_options' => array(
                    'Male' => 'Male',
                    'Female' => 'Female',

                ),

            ),


            'attributes' => array(
                'id' => 'gender',
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submitbutton',
                'class' => 'btn btn-block btn-primary pull-right',

            ),
        ));
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'firstName',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'email',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Email Address',
                        'options' => array(
                            'encoding' => 'UTF-8',

                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'country',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),

            ));


            $inputFilter->add(array(
                'name' => 'phone_no',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 15,
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'gender',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
