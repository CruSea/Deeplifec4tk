<?php

namespace Movement\Form;

use Zend\Form\Form;

class QuestionForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('movement');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'question',
            'attributes' => array(
                'type'  => 'text',
                 'class'    => 'form-control',
                   'required' => 'required',
            ),
            'options' => array(
                'label' => 'Question',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Textarea',
                 'class'    => 'form-control',
                   'required' => 'required',
            ),
            'options' => array(
                'label' => 'Description',
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
                           'id'       => 'category',
                           'class'    => 'form-control',
                           'required' => 'required',
                            ),
        ));

        $this->add(array(
            'name' => 'subcategory',
            'attributes' => array(
                'id'       => 'subcategory',
                'type'  => 'hidden',
                'class'    => 'form-control'
            ),
            'options' => array(
                'label' => 'Folder')
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
            'name' => 'mandatory',
            'type' => 'Select',
            'options' => array(
                'label' => 'Mandatory',
                
          'value_options' => array(
                           '1' => 'YES',
                           '0' => 'NO',
                          
                     ),       
         
            ), 
            'attributes' => array(
                           'id'       => 'mandatory',
                           'class'    => 'form-control',
                           'required' => 'required',
                            ),
        ));

  $this->add(array(
            'name' => 'type',
            'type' => 'Select',
            'options' => array(
                'label' => 'Type',
                
          'value_options' => array(
                           'YESNO' => 'YES/NO Question',
                           'NUMBER' => 'NUMBER Question',
                          
                     ),       
         
            ), 
            
         
            'attributes' => array(
                           'id'       => 'type',
                           'class'    => 'form-control',
                           'required' => 'required',
                            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                 'class'    => 'btn btn-primary',
            ),
        ));
    }
}