<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 4/4/2016
 * Time: 4:07 PM
 */

namespace DeepLife_API\Model;


class UserReport
{
    protected $user_id;
    protected $report_id;
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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
    public function getReportId()
    {
        return $this->report_id;
    }

    /**
     * @param mixed $report_id
     */
    public function setReportId($report_id)
    {
        $this->report_id = $report_id;
    }

}