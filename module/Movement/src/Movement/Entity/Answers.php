<?php

namespace Movement\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * answers.
 *
 * @ORM\Entity
 * @ORM\Table(name="answers")
 * @property string $answer
 * @property string $stage
 * @property datetime $created
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property int $country
*  */
class Answers 
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
    protected $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $question_id;

  
   /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

  /**
     * @ORM\Column(type="string")
     */
    protected $answer;

  /**
     * @ORM\Column(type="integer")
     */
    protected $country;
  
  
   /**
     * @ORM\Column(type="string")
     */
    protected $stage;
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
        $this->category = $data['user_id'];
        $this->question_id = $data['question_id'];
        $this->country = $data['country'];
        $this->answer = $data['answer'];
         $this->stage = $data['stage'];
      
    
    }

   
   
}