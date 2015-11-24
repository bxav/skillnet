<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Rbac\Model\IdentityInterface;
use Sylius\Component\Rbac\Model\RoleInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends \App\User\Model\User implements EquatableInterface, IdentityInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $salt;


    /**
     * @ORM\Column(type="array")
     */
    protected $roles  = array('ROLE_API');

    /**
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="user")
     **/
    protected $employee;

    /**
     * @ORM\OneToOne(targetEntity="Customer", mappedBy="user")
     **/
    protected $customer;

    /**
     * @ORM\ManyToMany(targetEntity="Sylius\Component\Rbac\Model\RoleInterface")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")}
     *      )
     */
    protected $authorizationRoles;

    public function __construct()
    {
        parent::__construct();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->authorizationRoles = new ArrayCollection();
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }


    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    public function isEqualTo(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        if (!$user instanceof \Symfony\Component\Security\Core\User\UserInterface) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationRoles()
    {
        return $this->authorizationRoles;
    }

    /**
     * {@inheritdoc}
     */
    public function addAuthorizationRole(RoleInterface $role)
    {
        if (!$this->hasAuthorizationRole($role)) {
            $this->authorizationRoles->add($role);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAuthorizationRole(RoleInterface $role)
    {
        if ($this->hasAuthorizationRole($role)) {
            $this->authorizationRoles->removeElement($role);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasAuthorizationRole(RoleInterface $role)
    {
        return $this->authorizationRoles->contains($role);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = parent::getRoles();
        foreach ($this->getAuthorizationRoles() as $role) {
            $roles = array_merge($roles, $role->getSecurityRoles());
        }
        return $roles;
    }
}
