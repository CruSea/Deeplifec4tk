<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/26/2016
 * Time: 5:58 AM
 */

namespace DeepLife_API\Model;


class Questions
{
    protected $id;
    protected $category;
    protected $country_id;
    protected $question;
    protected $description;
    protected $mandatory;
    protected $type;
    protected $default_question;
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param mixed $country_id
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
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
    public function getMandatory()
    {
        return $this->mandatory;
    }

    /**
     * @param mixed $mandatory
     */
    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
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
    public function getDefaultQuestion()
    {
        return $this->default_question;
    }

    /**
     * @param mixed $default_question
     */
    public function setDefaultQuestion($default_question)
    {
        $this->default_question = $default_question;
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
            'category' => $this->getCategory(),
            'country' => $this->getCountryId(),
            'question' => $this->getQuestion(),
            'description' => $this->getDescription(),
            'mandatory' => $this->getMandatory(),
            'type' => $this->getType(),
            'default_question' => $this->getDefaultQuestion(),
            'created' => $this->getCreated(),
        );
    }
}