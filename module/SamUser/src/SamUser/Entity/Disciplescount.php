<?php
 
namespace SamUser\Entity;
 
use Doctrine\ORM\Mapping as ORM;

 
/**
 * country.
 *
 * @ORM\Entity
 * @ORM\Table(name="disciplestreecount")
 * @property int $id
 * @property int $user_id
 * @property int $disciplescount
 */
class Disciplescount 
{
   
 
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
  
    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;

   
  
   /**
     * @ORM\Column(type="integer")
     */
    protected $disciplescount;

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
         $this->user_id = $data['user_id'];
         $this->disciplescount = $data['disciplescount'];
       

    }
 
   
 
   
}
