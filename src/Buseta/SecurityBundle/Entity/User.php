<?php
namespace Buseta\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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


    public function __construct()
    {
        parent::__construct();
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
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     *
     * @return $this
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
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
     *
     * @return $this
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }
}
