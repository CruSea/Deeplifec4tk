<?php
namespace SamUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * country.
 * @ORM\Entity
 * @ORM\Table(name="area_groups")
 * @property string $groups_name
 * @property string $countries_ids
 */
class Areagroups
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string");
     */
    protected $countries_ids;


    /**
     * @ORM\Column(type="string")
     */
    protected $groups_name;


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
    public function exchangeArray($data = array())
    {
        $this->id = $data['id'];
        $this->countries_ids = $data['countries_ids'];
        $this->groups_name = $data['groups_name'];


    }


}
