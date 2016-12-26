<?php
namespace Movement\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Stdlib\DateTime;
/**
 * questions.
 *
 * @ORM\Entity
 * @ORM\Table(name="questions")
 * @property int $category
 * @property string $question
 * @property string $description
 * @property int $mandatory
  *  @property int $id
  *  @property datetime $created
 */

class Questions implements InputFilterAwareInterface 
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
    protected $category;

    protected $subcategory;
    protected $answer;

    /**
     * @ORM\Column(type="string")
     */
    protected $question;
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
    protected $mandatory;

  /**
     * @ORM\Column(type="string")
     */
    protected $type;  

  /**
     * @ORM\Column(type="integer")
     */
    protected $country;
  
  
   /**
     * @ORM\Column(type="integer")
     */
    protected $default_question;
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
        $this->category = $data['category'];
        $this->question = $data['question'];
        $this->description = $data['description'];
        $this->mandatory = $data['mandatory'];
        $this->type = $data['type'];
        $this->country=$data['country'];
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
                'name'     => 'question',
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