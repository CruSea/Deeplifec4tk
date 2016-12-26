<?php
 
namespace SamUser\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
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
 * @property string $password
 * @property string $displayName
 * @property string $phone_no
 * @property string $picture
 * @property string $userlocale
*  * @property string $stage
 *  @property datetime $role_id
 * @property datetime $created
  * @property int $id
 */
class Users implements InputFilterAwareInterface , UserInterface
{
   
   
    protected $inputFilter;
 
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
  
   /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
   
  
    /**
     * @ORM\Column(type="string")
     */
    protected $userlocale;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    
    

 /**
     * @ORM\Column(type="string")
     */
    protected $displayName;
    
     /**
     * @ORM\Column(type="string")
     */
    protected $firstName;
 
 /**
     * @ORM\Column(type="string")
     */
    protected $phone_no;
 

 
     /**
        * @ORM\Column(type="string");
     * */
    protected $country;
    
    /** * @ORM\Column(type="string")
       
     */
    protected $password;

   
      /**
     * @ORM\Column(type="string")
     */
    protected $picture;
   
  
 
 /**
     * @ORM\Column(type="integer")
     */
    protected $role_id;
 
  
  
  
      /**
     * @ORM\Column(type="string")
     */
    protected $stage;
 
 /**
     * @ORM\Column(type="integer")
     */
    protected $mentor_id;
 
  /**
     * @ORM\Column(type="string")
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
        $this->displayName = $data['firstName'];
        $this->firstName = $data['firstName'];
        $this->country = $data['country'];
        $this->phone_no = $data['phone_no'];
        $this->mentor_id = $data['mentor_id'];
        $this->stage = $data['stage'];
        $this->role_id = $data['role_id'];
         $this->password = $data['password'];
        $this->picture =isset($data['picture'])?$data['picture']:'';
        $this->gender = $data['gender'];
      // $this->userlocale = $data['userlocale'];

    }
    
    
     /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
  


 /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

  /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName ? $this->displayName : "{$this->firstName}";
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
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
                'name'     => 'firstName',
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
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'encoding' => 'UTF-8',
                           
                        ),
                    ),
                ),
            ));
           
             $inputFilter->add(array(
                'name'     => 'country',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                
            ));

  

 

  $inputFilter->add(array(
                'name'     => 'phone_no',
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
                            'max'      => 15,
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
                'required' => FALSE,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
               
            ));
            



$inputFilter->add(array(
                'name'     => 'gender',
                'required' => true,
                'filters'  => array(
                   array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }




}
