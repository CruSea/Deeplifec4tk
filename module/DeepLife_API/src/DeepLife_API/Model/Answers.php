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
    protected $question_id;
    protected $answer;
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
            'answer' => $this->getAnswer(),
            'created' => $this->getCreated(),
        );
    }
}