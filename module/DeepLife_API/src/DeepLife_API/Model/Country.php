<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 4/4/2016
 * Time: 10:54 AM
 */

namespace DeepLife_API\Model;


class Country
{
    protected $id;
    protected $iso;
    protected $iso3;
    protected $name;
    protected $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

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
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param mixed $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    /**
     * @return mixed
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * @param mixed $iso3
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
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

    public function getArray()
    {
        return array(
            'id' => $this->getId(),
            'iso' => $this->getIso(),
            'iso3' => $this->getIso3(),
            'name' => $this->getName(),
            'code' => $this->getCode(),
        );
    }

}