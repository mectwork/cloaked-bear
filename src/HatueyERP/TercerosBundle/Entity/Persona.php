<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueyERP\TercerosBundle\Form\Model\PersonaModel;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 *
 * @ORM\Table(name="c_persona")
 * @ORM\Entity
 */
class Persona
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="persona")
     * @ORM\JoinColumn(name="tercero_id", onDelete="CASCADE")
     */
    private $tercero;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=32, nullable=true)
     * @Assert\Choice(choices={"masculino","femenino","no_aplica"})
     */
    private $sexo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula", type="string", length=32, nullable=true)
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_madre", type="string", nullable=true)
     */
    private $nombreMadre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_padre", type="string", nullable=true)
     */
    private $nombrePadre;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula_madre", type="string", nullable=true)
     */
    private $cedulaMadre;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula_padre", type="string", nullable=true)
     */
    private $cedulaPadre;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="talla_camiseta", type="string", nullable=true)
     */
    private $tallaCamiseta;

    /**
     * @var string
     *º
     * @ORM\Column(name="talla_pantalon", type="string", nullable=true)
     */
    private $tallaPantalon;

    /**
     * @var string
     *
     * @ORM\Column(name="talla_short", type="string", nullable=true)
     */
    private $tallaShort;

    /**
     * @ORM\Column(name="trabaja", type="boolean", nullable=true)
     */
    private $trabaja;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NProfesion
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NProfesion")
     * @ORM\JoinColumn(name="profesion_id")
     */
    private $profesion;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NNacionalidad
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NNacionalidad")
     * @ORM\JoinColumn(name="nacionalidad_id")
     */
    private $nacionalidad;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Buseta\NomencladorBundle\Entity\NPasatiempoHabilidad")
     * @ORM\JoinTable(name="c_persona_pasatiempo_habilidad",
     *  joinColumns={@ORM\JoinColumn(name="persona_id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="pasatiempo_habilidad_id")})
     */
    private $pasatiemposHabilidades;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NIdioma
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NIdioma")
     * @ORM\JoinColumn(name="idioma1_id")
     */
    private $idioma1;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NIdioma
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NIdioma")
     * @ORM\JoinColumn(name="idioma2_id")
     */
    private $idioma2;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NEstadoCivil
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NEstadoCivil")
     * @ORM\JoinColumn(name="estado_civil_id")
     */
    private $estadoCivil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pasatiemposHabilidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setModelData(PersonaModel $model)
    {
        $this->sexo             = $model->getSexo();
        $this->fechaNacimiento  = $model->getFechaNacimiento();
        $this->edad             = $model->getEdad();
        $this->cedula           = $model->getCedula();
        $this->nombreMadre      = $model->getNombreMadre();
        $this->cedulaMadre      = $model->getCedulaMadre();
        $this->nombrePadre      = $model->getNombrePadre();
        $this->cedulaPadre      = $model->getCedulaPadre();
        $this->email            = $model->getEmail();
        $this->tallaCamiseta    = $model->getTallaCamiseta();
        $this->tallaPantalon    = $model->getTallaPantalon();
        $this->tallaShort       = $model->getTallaShort();
        $this->trabaja          = $model->isTrabaja();
        $this->profesion        = $model->getProfesion();
        $this->nacionalidad     = $model->getNacionalidad();
        $this->idioma1          = $model->getIdioma1();
        $this->idioma2          = $model->getIdioma2();
        $this->estadoCivil      = $model->getEstadoCivil();
        $this->pasatiemposHabilidades = $model->getPasatiemposHabilidades();

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Persona
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Persona
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        if(($this->edad === null || $this->edad === '') && $this->fechaNacimiento !== null) {
            $diff = date_diff($this->fechaNacimiento, new \Datetime());
            return $diff->y;
        }

        return $this->edad;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return Persona
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set nombreMadre
     *
     * @param string $nombreMadre
     * @return Persona
     */
    public function setNombreMadre($nombreMadre)
    {
        $this->nombreMadre = $nombreMadre;

        return $this;
    }

    /**
     * Get nombreMadre
     *
     * @return string 
     */
    public function getNombreMadre()
    {
        return $this->nombreMadre;
    }

    /**
     * Set nombrePadre
     *
     * @param string $nombrePadre
     * @return Persona
     */
    public function setNombrePadre($nombrePadre)
    {
        $this->nombrePadre = $nombrePadre;

        return $this;
    }

    /**
     * Get nombrePadre
     *
     * @return string 
     */
    public function getNombrePadre()
    {
        return $this->nombrePadre;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Persona
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tallaCamiseta
     *
     * @param string $tallaCamiseta
     * @return Persona
     */
    public function setTallaCamiseta($tallaCamiseta)
    {
        $this->tallaCamiseta = $tallaCamiseta;

        return $this;
    }

    /**
     * Get tallaCamiseta
     *
     * @return string 
     */
    public function getTallaCamiseta()
    {
        return $this->tallaCamiseta;
    }

    /**
     * Set tallaPantalon
     *
     * @param string $tallaPantalon
     * @return Persona
     */
    public function setTallaPantalon($tallaPantalon)
    {
        $this->tallaPantalon = $tallaPantalon;

        return $this;
    }

    /**
     * Get tallaPantalon
     *
     * @return string 
     */
    public function getTallaPantalon()
    {
        return $this->tallaPantalon;
    }

    /**
     * Set tallaShort
     *
     * @param string $tallaShort
     * @return Persona
     */
    public function setTallaShort($tallaShort)
    {
        $this->tallaShort = $tallaShort;

        return $this;
    }

    /**
     * Get tallaShort
     *
     * @return string 
     */
    public function getTallaShort()
    {
        return $this->tallaShort;
    }

    /**
     * Set trabaja
     *
     * @param boolean $trabaja
     * @return Persona
     */
    public function setTrabaja($trabaja)
    {
        $this->trabaja = $trabaja;

        return $this;
    }

    /**
     * Get trabaja
     *
     * @return boolean 
     */
    public function getTrabaja()
    {
        return $this->trabaja;
    }

    /**
     * Set tercero
     *
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     * @return Persona
     */
    public function setTercero(\HatueyERP\TercerosBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero
     *
     * @return \HatueyERP\TercerosBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set profesion
     *
     * @param \Buseta\NomencladorBundle\Entity\NProfesion $profesion
     * @return Persona
     */
    public function setProfesion(\Buseta\NomencladorBundle\Entity\NProfesion $profesion = null)
    {
        $this->profesion = $profesion;

        return $this;
    }

    /**
     * Get profesion
     *
     * @return \Buseta\NomencladorBundle\Entity\NProfesion 
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * Set nacionalidad
     *
     * @param \Buseta\NomencladorBundle\Entity\NNacionalidad $nacionalidad
     * @return Persona
     */
    public function setNacionalidad(\Buseta\NomencladorBundle\Entity\NNacionalidad $nacionalidad = null)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return \Buseta\NomencladorBundle\Entity\NNacionalidad 
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Add pasatiemposHabilidades
     *
     * @param \Buseta\NomencladorBundle\Entity\NPasatiempoHabilidad $pasatiemposHabilidades
     * @return Persona
     */
    public function addPasatiemposHabilidade(\Buseta\NomencladorBundle\Entity\NPasatiempoHabilidad $pasatiemposHabilidades)
    {
        $this->pasatiemposHabilidades[] = $pasatiemposHabilidades;

        return $this;
    }

    /**
     * Remove pasatiemposHabilidades
     *
     * @param \Buseta\NomencladorBundle\Entity\NPasatiempoHabilidad $pasatiemposHabilidades
     */
    public function removePasatiemposHabilidade(\Buseta\NomencladorBundle\Entity\NPasatiempoHabilidad $pasatiemposHabilidades)
    {
        $this->pasatiemposHabilidades->removeElement($pasatiemposHabilidades);
    }

    /**
     * Get pasatiemposHabilidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPasatiemposHabilidades()
    {
        return $this->pasatiemposHabilidades;
    }

    /**
     * Set idioma1
     *
     * @param \Buseta\NomencladorBundle\Entity\NIdioma $idioma1
     * @return Persona
     */
    public function setIdioma1(\Buseta\NomencladorBundle\Entity\NIdioma $idioma1 = null)
    {
        $this->idioma1 = $idioma1;

        return $this;
    }

    /**
     * Get idioma1
     *
     * @return \Buseta\NomencladorBundle\Entity\NIdioma 
     */
    public function getIdioma1()
    {
        return $this->idioma1;
    }

    /**
     * Set idioma2
     *
     * @param \Buseta\NomencladorBundle\Entity\NIdioma $idioma2
     * @return Persona
     */
    public function setIdioma2(\Buseta\NomencladorBundle\Entity\NIdioma $idioma2 = null)
    {
        $this->idioma2 = $idioma2;

        return $this;
    }

    /**
     * Get idioma2
     *
     * @return \Buseta\NomencladorBundle\Entity\NIdioma 
     */
    public function getIdioma2()
    {
        return $this->idioma2;
    }

    /**
     * Set estadoCivil
     *
     * @param \Buseta\NomencladorBundle\Entity\NEstadoCivil $estadoCivil
     * @return Persona
     */
    public function setEstadoCivil(\Buseta\NomencladorBundle\Entity\NEstadoCivil $estadoCivil = null)
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return \Buseta\NomencladorBundle\Entity\NEstadoCivil 
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    public function __toString()
    {
        return $this->getTercero()->getNombres() . ' ' . $this->getTercero()->getApellidos();
    }

    /**
     * Set cedulaMadre
     *
     * @param string $cedulaMadre
     * @return Persona
     */
    public function setCedulaMadre($cedulaMadre)
    {
        $this->cedulaMadre = $cedulaMadre;

        return $this;
    }

    /**
     * Get cedulaMadre
     *
     * @return string 
     */
    public function getCedulaMadre()
    {
        return $this->cedulaMadre;
    }

    /**
     * Set cedulaPadre
     *
     * @param string $cedulaPadre
     * @return Persona
     */
    public function setCedulaPadre($cedulaPadre)
    {
        $this->cedulaPadre = $cedulaPadre;

        return $this;
    }

    /**
     * Get cedulaPadre
     *
     * @return string 
     */
    public function getCedulaPadre()
    {
        return $this->cedulaPadre;
    }
}
