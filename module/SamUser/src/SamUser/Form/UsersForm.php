<?php

namespace SamUser\Form;

use Zend\Form\Form;

class UsersForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('SamUser');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
       
       $this->add(array(
            'name' => 'mentor_id',
            'type' => 'Hidden',
        ));
        
         $this->add(array(
            'name' => 'stage',
            'type' => 'Hidden',
        ));
         
          $this->add(array(
            'name' => 'password',
            'type' => 'Hidden',
        ));
        
          $this->add(array(
            'name' => 'role_id',
            'type' => 'Hidden',
        ));
            $this->add(array(
            'name' => 'picture',
            'type' => 'File',
            'options' => array(
                'label' => 'Picture',
                
            ), 'attributes' => array(
                           'id'       => 'picture',
                               'class'    => 'form-control',
                            'required' => 'required',
                            ),
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
            'name' => 'countrycode',
            'type' => 'Select',
            'options' => array(
                'label' => 'Countrycode',
                 'empty_option' => 'Select', 
                   'value_options' => array(
                             
                         
                     ),  
            ), 'attributes' => array(
                           'id'       => 'countrycode',
                           'class'    => 'form-control',
                                            
                           
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
                'value' => 'Save',
                'id' => 'submitbutton',
                 'class'    => 'btn btn-primary pull-right',
                
            ),
        ));
    }
}
