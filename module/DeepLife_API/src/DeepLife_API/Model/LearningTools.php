<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 12/29/16
 * Time: 11:08 AM
 */

namespace DeepLife_API\Model;


class LearningTools
{
    protected $id;
    protected $title;
    protected $description;
    protected $iframcode;
    protected $country;
    protected $default_learn;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getIframcode()
    {
        return $this->iframcode;
    }

    /**
     * @param mixed $iframcode
     */
    public function setIframcode($iframcode)
    {
        $this->iframcode = $iframcode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getDefaultLearn()
    {
        return $this->default_learn;
    }

    /**
     * @param mixed $default_learn
     */
    public function setDefaultLearn($default_learn)
    {
        $this->default_learn = $default_learn;
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

    public function getArray()
    {
        return array(
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'iframcode' => $this->getIframcode(),
            'country' => $this->getCountry(),
            'default_learn' => $this->getDefaultLearn(),
            'created' => $this->getCreated(),
        );
    }
}