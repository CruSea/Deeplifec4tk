<?php
 
namespace SamUser\Entity;
 
use Doctrine\ORM\Mapping as ORM;

 
/**
 * country.
 *
 * @ORM\Entity
 * @ORM\Table(name="country")
 * @property string $iso
  * @property string $iso3
 *   @property string $name
 *    @property string $phonecode
 * @property int $id
 */
class Country 
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
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $phonecode;

    /**
     * @ORM\Column(type="string")
     */
    protected $iso;

   /**
     * @ORM\Column(type="string")
     */
    protected $iso3;

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
        $this->name = $data['name'];
       

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
