<?php

namespace Movement\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * answers.
 *
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @property string $name
 * @property datetime $created
 * @property int $id
 * @property int $status
 * @property int $parent
*  */
class Categories 
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
    protected $parent;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

  
   /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

  /**
     * @ORM\Column(type="string")
     */
    protected $name;

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
        $this->name = $data['name'];
        $this->status = $data['status'];
        $this->parent = $data['parent'];
    }

   
   
}