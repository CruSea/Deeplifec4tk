<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 12/30/16
 * Time: 2:38 AM
 */

namespace DeepLife_API\Model;


class DiscipleTree
{
    protected $ID;
    protected $UserID;
    protected $DiscipleCount;

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID)
    {
        $this->UserID = $UserID;
    }

    /**
     * @return mixed
     */
    public function getDiscipleCount()
    {
        return $this->DiscipleCount;
    }

    /**
     * @param mixed $DiscipleCount
     */
    public function setDiscipleCount($DiscipleCount)
    {
        $this->DiscipleCount = $DiscipleCount;
    }

    public function getArray()
    {
        return array(
            'id' => $this->getID(),
            'user_id' => $this->getUserID(),
            'disciple_count' => $this->getDiscipleCount(),
        );
    }

    

}