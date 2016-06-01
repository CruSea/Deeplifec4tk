<?php
namespace Testimonial\Form;

use Zend\Form\Form;

class TestimonialForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('testimonial');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
     
          $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'textarea',
                'rows'=>"4", 
                'cols'=>"50",
                 'class'    => 'form-control',
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
                           'id'       => 'country',
                           'class'    => 'form-control',
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
                           'id'       => 'status',
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