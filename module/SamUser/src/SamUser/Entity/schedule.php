<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SamUser\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

use Zend\Form\Annotation as ZFA;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="schedule")0
 *
 * @ZFA\Name("user")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Schedule implements UserInterface, ProviderInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Attributes({"type":"hidden"})
     */
    protected $sid = null;


    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"John"})
     * @ZFA\Options({"label":"Schedule Name"})
     */
    protected $scheduleName = null;


    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"Win"})
     * @ZFA\Options({"label":"catagory"})
     */
    protected $catagory = null;


    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"id"})
     * @ZFA\Options({"label":"User_id"})
     */
    protected $user_Id = null;
    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"id"})
     * @ZFA\Options({"label":"disc_id"})
     */
    protected $disc_Id = null;

    public function toArray()
    {
        return array(
            'sid' => $this->getSId(),
            'scheduleName' => $this->getScheduleName(),
            'catagory' => $this->getCatagory(),
            'user_id' => $this->getId(),
            'disc_id' => $this->getId(),

        );
    }


    /**
     * @return string
     */
    public function getCatagory()
    {
        return $this->catagory;
    }

    /**
     * @param string $catagory
     */
    public function setCatagory($catagory)
    {
        $this->country = $catagory;
    }

    public function __toString()
    {
        return "{$this->getCatagory()}>";
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->user_Idid;
    }

    /**
     * Set id.
     *
     * @param int $user_id
     *
     * @return void
     */
    public function setId($user_id)
    {
        $this->id = (int)$user_id;
        return $this;
    }


    /**
     * Get scheduleName.
     *
     * @return string
     */
    public function getScheduleName()
    {
        return $this->scheduletName;
    }

    /**
     * Set scheduleName.
     *
     * @param string $scheduleName
     *
     * @return void
     */
    public function setScheduleName($scheduleName)
    {
        $this->scheduleName = $scheduleName;

        return $this;
    }


    /**
     * @return \Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return UserInterface
     */
    public function setUsername($username)
    {
        // TODO: Implement setUsername() method.
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * Set email.
     *
     * @param string $email
     * @return UserInterface
     */
    public function setEmail($email)
    {
        // TODO: Implement setEmail() method.
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        // TODO: Implement getDisplayName() method.
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName)
    {
        // TODO: Implement setDisplayName() method.
    }

    /**
     * Get password.
     *
     * @return string password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return UserInterface
     */
    public function setPassword($password)
    {
        // TODO: Implement setPassword() method.
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        // TODO: Implement getState() method.
    }

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state)
    {
        // TODO: Implement setState() method.
    }
}
