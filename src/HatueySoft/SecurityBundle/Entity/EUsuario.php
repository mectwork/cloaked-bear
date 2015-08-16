<?php

namespace HatueySoft\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use HatueySoft\SecurityBundle\Validator\Constraints\UniqueSystemUserEmail;
use HatueySoft\SecurityBundle\Validator\Constraints\UniqueSystemUserUsername;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @author: firomero <firomerorom4@gmail.com>
 * @author: dundivet <dundivet@emailn.de>
 *
 * @ORM\Entity(repositoryClass="HatueySoft\SecurityBundle\Entity\EUsuarioRepository")
 * @ORM\Table(name="security_fos_user")
 * @UniqueEntity(fields={"username", "email"})
 */
class EUsuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @UniqueSystemUserUsername()
     */
    protected $username;

    /**
     * @var string
     * @UniqueSystemUserEmail()
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="HatueySoft\SecurityBundle\Entity\EGrupo")
     * @ORM\JoinTable(name="security_fos_users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=64)
     * @Assert\NotBlank
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=64, nullable=true)
     */
    private $apellidos;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="HatueySoft\UploadBundle\Entity\UploadResources", cascade={"persist", "remove"})
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="pin", type="string", length=4, nullable=true)
     */
    private $pin;

    function __construct()
    {
        parent::__construct();

        $this->enabled = true;
    }


    public function isActive()
    {
        return $this->locked == false;
    }

    public function setActive($value)
    {
        $this->locked = !$value;
    }

    public  function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
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
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
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
}
