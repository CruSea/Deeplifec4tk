<?php

namespace News\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Stdlib\DateTime;
/**
 * answers.
 *
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @property string $title
 * @property string $description
*  @property int $user_id
*  @property string $country
*  @property string $image
*   @property int $status
* @property int $id
* @property datetime $created

*  */
class News implements InputFilterAwareInterface 
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
      protected $status;

  /**
     * @ORM\Column(type="string")
     */
      protected $title;

/**
     * @ORM\Column(type="string")
     */
      protected $image;

/**
     * @ORM\Column(type="datetime")
     */
    protected $created;


/**
     * @ORM\Column(type="string")
     */
       protected $description;
 /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;
  
   /**
     * @ORM\Column(type="string")
     */
    protected $country;
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
        $this->country = $data['country'];
        $this->description = $data['description'];
        $this->user_id = $data['user_id'];
        $this->title = $data['title'];
        $this->status = $data['status'];
        $this->image = $data['image'];
        $this->created = new DateTime(); 
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
                'name'     => 'title',
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