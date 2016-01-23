<?php

namespace HatueySoft\SecurityBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use HatueySoft\SecurityBundle\Entity\User;
use HatueySoft\SecurityBundle\Validator\Constraints\UniqueSystemUserEmail;
use HatueySoft\SecurityBundle\Validator\Constraints\UniqueSystemUserUsername;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserModel
 *
 * @package HatueySoft\SecurityBundle\Form\Model
 *
 * @UniqueSystemUserUsername()
 * @UniqueSystemUserEmail()
 */
class UserModel
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $groups;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombres;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     */
    private $foto;

    /**
     * @var string
     */
    private $pin;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $grupobuses;


    /**
     * UserModel constructor.
     *
     * @param User $user
     */
    public function __construct(User $user = null)
    {
        if ($user !== null) {
            $this->id = $user->getId();
            $this->username = $user->getUsername();
            $this->email = $user->getEmail();
            $this->nombres = $user->getNombres();
            $this->apellidos = $user->getApellidos();

            if (count($user->getRoles()) > 0) {
                $this->roles = array();
                foreach ($user->getRoles() as $role) {
                    $this->roles[] = $role;
                }
            }

            if (count($user->getGroups()) > 0) {
                $this->groups = new ArrayCollection();
                foreach ($user->getGroups() as $group) {
                    $this->groups->add($group);
                }
            }

            if (count($user->getGrupoBuses()) > 0) {
                $this->grupobuses = new ArrayCollection();
                foreach ($user->getGrupoBuses() as $grupoBuse) {
                    $this->grupobuses->add($grupoBuse);
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param string $pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getGrupobuses()
    {
        return $this->grupobuses;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $grupobuses
     */
    public function setGrupobuses($grupobuses)
    {
        $this->grupobuses = $grupobuses;
    }
}
