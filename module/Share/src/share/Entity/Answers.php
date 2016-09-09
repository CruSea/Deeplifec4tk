<?php

namespace Share\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\DateTime;

/**
 * reports.
 *
 * @ORM\Entity
 * @ORM\Table(name="reports")
 * @property string $value
 * @property string $stage
 * @property datetime $created
 * @property int $id
 * @property int $user_id
 * @property int $report_form_id
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
    protected $report_form_id;


    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="string")
     */
    protected $value;

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
        $this->report_form_id = $data['report_form_id'];
        $this->country = $data['country'];
        $this->value = $data['value'];
        $this->stage = $data['stage'];
        $this->created = new DateTime();

    }


}