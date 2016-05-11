<?php
namespace Schedules\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
/**
 
 * @ORM\Entity
 * @ORM\Table(name="schedule")
 * @property string $time
 * @property string $description
*  @property string $name
*  @property string $type
*  @property string $disciple_phone
*  @property int $user_Id
*  @property int $id


*  */
class Schedule implements InputFilterAwareInterface 
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
      protected $id;

     /**
     * @ORM\Column(type="integer")
     */
      protected $user_Id;

    /**
     * @ORM\Column(type="string")
     */
      protected $name;
      
        /**
     * @ORM\Column(type="string")
     */
      protected $disciple_phone;

     /**
     * @ORM\Column(type="string")
     */
       protected $description;
     /**
     * @ORM\Column(type="string")
     */
      protected $type;
    
    
    /**
     * @ORM\Column(type="string")
     */
      protected $time;
    
    
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->id = $data['id'];
        $this->user_Id = $data['user_Id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->type = 'Normal';
        $this->disciple_phone = $data['disciple_phone'];
        $this->time = $data['time'];
    
    }

     public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'id',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

 
   


   $inputFilter->add($factory->createInput(array(
                'name'     => 'txtdate',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 300,
                        ),
                    ),
                ),
            )));


$inputFilter->add($factory->createInput(array(
                'name'     => 'txttime',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 300,
                        ),
                    ),
                ),
            )));
   
   $inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1000,
                        ),
                    ),
                ),
            )));
 

 



            $this->inputFilter = $inputFilter;        
        }



        return $this->inputFilter;
    } 
   
}
