<?php
namespace Application\Form;
use Zend\Form\Form;

class RegisterForm extends Form
{
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
                           'id'       => 'firstName',
                            'class'    => 'form-control',
                         
                            ),
        ));
     
       
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                'label' => 'Email',
                            ),
                             'attributes' => array(
                             'id'       => 'email',
                             'class'    => 'form-control',
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
                           'id'       => 'country',
                           'class'    => 'form-control',
                           'required' => 'required',
                        
                           
                            ),
        ));
     
        $this->add(array(
            'name' => 'phone_no',
            'type' => 'Text',
            'options' => array(
                'label' => 'Phone',
                
            ), 'attributes' => array(
                           'id'       => 'phone_no',
                           'class'    => 'form-control',
                             'required' => 'required',
                            ),
        ));
    
        
         $this->add(array(
            'name' => 'gender',
            'type' => 'Select',
            'options' => array(
                'label' => 'Gender',
                 'id'       => 'gender',
                      'class'    => 'form-control',
                             'required' => 'required',
          'value_options' => array(
                           'Male' => 'Male',
                             'Female' => 'Female',
                             
                     ),       
         
            ), 
            
         
            'attributes' => array(
                           'id'       => 'gender',
                           'class'    => 'form-control',
                           'required' => 'required',
                            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                 'class'    => 'btn btn-primary pull-right',
                
            ),
        ));
    }
}
