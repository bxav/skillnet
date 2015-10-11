<?php
namespace AppBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

trait UserTrait
{

    /**
     * @ORM\Column(type="string")
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"read", "write"})
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
    protected $roles;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\Groups({"read", "write"})
     */
    protected $plainPassword;

    public function initUser()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->roles = [];
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getRoles()
    {
        return $this->roles;
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



    public function isEqualTo(SymfonyUserInterface $user)
    {
        if (!$user instanceof SymfonyUserInterface) {
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

}
