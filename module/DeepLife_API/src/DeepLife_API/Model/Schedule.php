<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 1:03 PM
 */

namespace DeepLife_API\Model;


class Schedule
{
    protected $id;
    protected $user_id;
    protected $disciple_phone;
    protected $name;
    protected $time;
    protected $type;
    protected $description;
    protected $created;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDisciplePhone()
    {
        return $this->disciple_phone;
    }

    /**
     * @param mixed $disciple_phone
     */
    public function setDisciplePhone($disciple_phone)
    {
        $this->disciple_phone = $disciple_phone;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getArray(){
        return array(
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'disciple_phone' => $this->getDisciplePhone(),
            'name' => $this->getName(),
            'time' => $this->getTime(),
            'type' => $this->getType(),
            'description' => $this->getDisciplePhone(),
            'created' => $this->getCreated(),
        );
    }
}