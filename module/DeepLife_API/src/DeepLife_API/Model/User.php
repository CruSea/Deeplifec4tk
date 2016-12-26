<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 3/25/2016
 * Time: 12:57 PM
 */

namespace DeepLife_API\Model;


class User
{
    protected $id;
    protected $email;
    protected $displayName;
    protected $password;
    protected $firstName;
    protected $country;
    protected $phone_no;
    protected $mentor_id;
    protected $picture;
    protected $gender;
    protected $stage;
    protected $role_id;
    protected $userlocale;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
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
    public function getPhoneNo()
    {
        return $this->phone_no;
    }

    /**
     * @param mixed $phone_no
     */
    public function setPhoneNo($phone_no)
    {
        $this->phone_no = $phone_no;
    }

    /**
     * @return mixed
     */
    public function getMentorId()
    {
        return $this->mentor_id;
    }

    /**
     * @param mixed $mentor_id
     */
    public function setMentorId($mentor_id)
    {
        $this->mentor_id = $mentor_id;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
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

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @return mixed
     */
    public function getUserlocale()
    {
        return $this->userlocale;
    }

    /**
     * @param mixed $userlocale
     */
    public function setUserlocale($userlocale)
    {
        $this->userlocale = $userlocale;
    }

    /**
     * @param mixed $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    public function getArray()
    {
        return array(
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'displayName' => $this->getDisplayName(),
            'password' => $this->getPassword(),
            'firstName' => $this->getFirstName(),
            'country' => $this->getCountry(),
            'phone_no' => $this->getPhoneNo(),
            'mentor_id' => $this->getMentorId(),
            'stage' => $this->getStage(),
            'role_id' => $this->getRoleId(),
            'gender' => $this->getGender(),
            'picture' => $this->getPicture(),
            'userlocale' => $this->getUserlocale(),
            'created' => $this->getCreated(),
        );
    }

}