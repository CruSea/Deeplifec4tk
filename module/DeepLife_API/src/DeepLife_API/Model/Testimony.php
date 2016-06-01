<?php
/**
 * Created by PhpStorm.
 * User: Roger
 * Date: 4/16/2016
 * Time: 11:19 PM
 */

namespace DeepLife_API\Model;


class Testimony
{
    protected $id;
    protected $user_id;
    protected $title;
    protected $detail;

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
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }
    public function getArray(){
        return array(
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'title' => $this->getTitle(),
            'detail' => $this->getDetail(),
        );
    }

}