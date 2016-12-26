<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/26/2016
 * Time: 6:10 AM
 */

namespace DeepLife_API\Model;


class Answers
{
    protected $id;
    protected $user_id;
    protected $disciple_phone;
    protected $question_id;
    protected $country;
    protected $answer;
    protected $stage;
    protected $notes;
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
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param mixed $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
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
            'user_id' => $this->getUserId(),
            'question_id' => $this->getQuestionId(),
            'disciple_phone' => $this->getDisciplePhone(),
            'country' => $this->getQuestionId(),
            'answer' => $this->getAnswer(),
            'stage' => $this->getStage(),
            'notes' => $this->getNotes(),
            'created' => $this->getCreated(),
        );
    }
}