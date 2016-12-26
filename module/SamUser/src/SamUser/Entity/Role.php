<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SamUser\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation as ZFA;

/**
 * An example entity that represents a role.
 *
 * @ORM\Entity
 * @ORM\Table(name="role")
 *
 * @ZFA\Name("role-form")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Role implements HierarchicalRoleInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ZFA\Exclude()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @ZFA\Attributes({"type":"text"})
     * @ZFA\Options({"label":"Name"})
     */
    protected $roleId;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="SamUser\Entity\Role")
     *
     * @ZFA\Attributes({"readonly":"false"})
     * @ZFA\Required(false)
     * @ZFA\Type("DoctrineORMModule\Form\Element\EntitySelect")
     * @ZFA\Options({"label":"Parent", "target_class":"SamUser\Entity\Role", "property":"roleId", "empty_option":"Choose a parent"})
     */
    protected $parent;


    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'roleId' => $this->getRoleId(),
            'parent' => isset($this->parent) ? $this->getParent()->toArray() : $this->getParent(),
        );
    }

    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * Get the role id.
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set the role id.
     *
     * @param string $roleId
     *
     * @return void
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
    }

    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent role.
     *
     * @param Role $role
     *
     * @return void
     */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
    }
}
