<?php
namespace Learningtools\Form;

use Zend\Form\Form;

class LearnForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('learn');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                 'class'    => 'form-control',
                   'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title',
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
            'name' => 'iframcode',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Textarea',
                 'class'    => 'form-control',
                   'required' => 'required',
            ),
            'options' => array(
                'label' => 'Youtube URL',
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
            'name' => 'default_learn',
            'type' => 'Select',
            'options' => array(
                'label' => 'Default',
                
          'value_options' => array(
                           '1' => 'YES',
                           '0' => 'NO',
                          
                     ),       
         
            ), 
            
         
            'attributes' => array(
                           'id'       => 'default',
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
                 'class'    => 'btn btn-primary pull-right',
            ),
        ));
    }






}