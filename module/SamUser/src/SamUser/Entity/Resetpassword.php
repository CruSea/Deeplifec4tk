<?php
 
namespace SamUser\Entity;
 
use Doctrine\ORM\Mapping as ORM;

 
/**
 * country.
 *
 * @ORM\Entity
 * @ORM\Table(name="resetpassword")
  * @property string $email
 *  @property string $keycode
 *  @property int $status
 * @property int $id
 */
class Resetpassword 
{
   
 
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

   
  
   /**
     * @ORM\Column(type="string")
     */
    protected $keycode;

  
   /**
     * @ORM\Column(type="integer")
     */
    protected $status;

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
        $this->keycode = $data['keycode'];
        $this->status = $data['status'];
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

          

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
