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
       
      /*  $this->add(array(
            'name' => 'mentor_id',
            'type' => 'Hidden',
        ));*/
         $this->add(array(
            'name' => 'full_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
                
            ), 'attributes' => array(
                           'id'       => 'full_name',
                            'class'    => 'form-control',
                             'required' => 'required',
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
            'name' => 'country_id',
            'type' => 'Select',
            'options' => array(
                'label' => 'Country',
                   'value_options' => array(
                             '1' => 'India',
                         
                     ),  
            ), 'attributes' => array(
                           'id'       => 'country_id',
                           'class'    => 'form-control',
                           'required' => 'required',
                        
                           
                            ),
        ));
     
        $this->add(array(
            'name' => 'phone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Phone',
                
            ), 'attributes' => array(
                           'id'       => 'phone',
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
                           '1' => 'Male',
                             '2' => 'Female',
                             
                     ),       
         
            ), 
            
         
            'attributes' => array(
                           'id'       => 'gender',
                           'class'    => 'form-control',
                           'required' => 'required',
                            ),
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                 'class'    => 'btn btn-primary',
                
            ),
        ));
    }
}
