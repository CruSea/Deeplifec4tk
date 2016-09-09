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
 * @ORM\Table(name="users")0
 *
 * @ZFA\Name("user")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class User implements UserInterface, ProviderInterface
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
    protected $id = null;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @ZFA\Attributes({"type":"email", "placeholder":"someone@domain.com"})
     * @ZFA\Options({"label":"Emailia"})
     */
    protected $email = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=true)
     *
     * @ZFA\Exclude()
     */
    protected $displayName = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"John"})
     * @ZFA\Options({"label":"Firsta Name"})
     */
    protected $firstName = null;

    /**
     * @var string
     * @ORM\Column(type="integer")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"Ethiopia"})
     * @ZFA\Options({"label":"country"})
     */
    protected $country = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"0916587396"})
     * @ZFA\Options({"label":"phone number"})
     */
    protected $phone_no = null;

    /**
     * @var string
     * @ORM\Column(type="integer")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"text", "placeholder":"0916587396"})
     * @ZFA\Options({"label":"mentor_id"})
     */
    protected $mentor_id = null;


    /**
     * @var int
     * @ORM\Column(type="string", length=100, nullable=true)
     * * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ZFA\Attributes({"type":"url", "placeholder":"c:/xampp/htdoc/fre,jpg"})
     * @ZFA\Options({"label":"picture"})
     */

    protected $picture = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":128}})
     * @ZFA\Attributes({"type":"password"})
     * @ZFA\Options({"label":"Passiword"})
     */
    protected $password = null;

    /**
     * @var int
     *
     * @ZFA\Exclude()
     */
    protected $state = null;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SamUser\Entity\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @ZFA\Exclude()
     */
    protected $roles;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'displayName' => $this->getDisplayName(),
            'firstName' => $this->getFirstName(),
            'middleName' => $this->getMiddleName(),
            'sureName' => $this->getSureName(),
            'country' => $this->getCountry(),
            'phone' => $this->getPhone(),
            'picture' => $this->getPicture(),
            //'state' => $this->getState(),
            //  'roles' => array_map(
            ///  function($r) { return array('id' => $r->getId()); },
            // $this->getRoles()->getValues()
            //)
        );
    }

    /**
     * @return string
     */
    public function getPhoneNo()
    {
        return $this->phone_no;
    }

    /**
     * @param string $phone_no
     */
    public function setPhoneNo($phone_no)
    {
        $this->phone_no = $phone_no;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function __toString()
    {
        return "{$this->getDisplayName()} <{$this->getEmail()}>";
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int)$id;
        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        $this->setDisplayName("{$this->firstName}");

        return $this;
    }


    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName ? $this->displayName : "{$this->firstName}";
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }
}
