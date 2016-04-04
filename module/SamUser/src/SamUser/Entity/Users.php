<?php
 
namespace SamUser\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
 
/**
 * users.
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @property string $email
 * @property string $displayName
 * @property int $id
 */
class Users implements InputFilterAwareInterface 
{
    protected $inputFilter;
 
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
  
    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /** * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $displayName;
 
    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;
   
   /**
        * @ORM\Column(type="integer");
     * */
    protected $country_id;
 
 
  /**
     * @ORM\Column(type="string")
     */
    protected $phone;
  
  
      /**
     * @ORM\Column(type="string")
     */
    protected $picture;
 
 /**
     * @ORM\Column(type="integer")
     */
    protected $mentor_id;
 
  /**
     * @ORM\Column(type="integer")
     */
    protected $gender;

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
    public function exchangeArray ($data = array()) 
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->displayName = $data['displayName'];
        $this->firstName = $data['firstName'];
        $this->country_id = $data['country_id'];
        $this->phone = $data['phone'];
        $this->mentor_id = $data['mentor_id'];
        $this->picture = $data['picture'];
        $this->gender = $data['gender'];
     

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
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'email',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'displayname',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

   $inputFilter->add(array(
                'name'     => 'firstname',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

   $inputFilter->add(array(
                'name'     => 'country_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

  $inputFilter->add(array(
                'name'     => 'phone',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

   $inputFilter->add(array(
                'name'     => 'mentor_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));




            
            $inputFilter->add(array(
                'name'     => 'picture',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));
            



$inputFilter->add(array(
                'name'     => 'gender',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
