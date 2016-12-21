<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/30/2016
 * Time: 10:25 PM
 */

namespace DeepLife_API\Model;


class Disciple
{
    protected $id, $userID, $DiscipleID;

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
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getDiscipleID()
    {
        return $this->DiscipleID;
    }

    /**
     * @param mixed $DiscipleID
     */
    public function setDiscipleID($DiscipleID)
    {
        $this->DiscipleID = $DiscipleID;
    }

}