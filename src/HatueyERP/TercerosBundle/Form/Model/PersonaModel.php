<?php

namespace HatueyERP\TercerosBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use HatueyERP\TercerosBundle\Entity\Persona;
use Symfony\Component\Validator\Constraints as Assert;

class PersonaModel
{
    /**
     * @var boolean
     */
    private $isPersona;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var string
     * @Assert\Choice(choices={"masculino","femenino","no_aplica"})
     */
    private $sexo;

    /**
     * @var \DateTime
     * @Assert\Date()
     */
    private $fechaNacimiento;

    /**
     * @var integer
     */
    private $edad;

    /**
     * @var string
     */
    private $cedula;

    /**
     * @var string
     */
    private $nombreMadre;

    /**
     * @var string
     */
    private $cedulaMadre;

    /**
     * @var string
     */
    private $nombrePadre;

    /**
     * @var string
     */
    private $cedulaPadre;

    /**
     * @var string
     * @Assert\Email()
     */
    private $email;
    /**
     * @var string
     */
    private $tallaCamiseta;

    /**
     * @var string
     */
    private $tallaPantalon;

    /**
     * @var string
     */
    private $tallaShort;

    /**
     * @var boolean
     */
    private $trabaja;

    /**
     * @var \Olimpiada\NomencladorBundle\Entity\NProfesion
     */
    private $profesion;

    /**
     * @var \Olimpiada\NomencladorBundle\Entity\NNacionalidad
     */
    private $nacionalidad;

    /**
     * @var \Olimpiada\NomencladorBundle\Entity\NIdioma
     */
    private $idioma1;

    /**
     * @var \Olimpiada\NomencladorBundle\Entity\NIdioma
     */
    private $idioma2;

    /**
     * @var \Olimpiada\NomencladorBundle\Entity\NEstadoCivil
     */
    private $estadoCivil;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $pasatiemposHabilidades;

    function __construct(Persona $persona = null)
    {
        $this->isPersona    = false;

        if($persona) {
            $this->isPersona        = true;
            $this->id               = $persona->getId();
            if($persona->getTercero()) {
                $this->tercero      = $persona->getTercero();
            }
            $this->sexo             = $persona->getSexo();
            $this->fechaNacimiento  = $persona->getFechaNacimiento();
            $this->edad             = $persona->getEdad();
            $this->cedula           = $persona->getCedula();
            $this->nombreMadre      = $persona->getNombreMadre();
            $this->cedulaMadre      = $persona->getCedulaMadre();
            $this->nombrePadre      = $persona->getNombrePadre();
            $this->cedulaPadre      = $persona->getCedulaPadre();
            $this->email            = $persona->getEmail();
            $this->tallaCamiseta    = $persona->getTallaCamiseta();
            $this->tallaPantalon    = $persona->getTallaPantalon();
            $this->tallaShort       = $persona->getTallaShort();
            $this->trabaja          = $persona->getTrabaja();
            if ($persona->getProfesion()) {
                $this->profesion    = $persona->getProfesion();
            }
            if ($persona->getNacionalidad()) {
                $this->nacionalidad = $persona->getNacionalidad();
            }
            if ($persona->getIdioma1()) {
                $this->idioma1      = $persona->getIdioma1();
            }
            if ($persona->getIdioma2()) {
                $this->idioma2      = $persona->getIdioma2();
            }
            if ($persona->getEstadoCivil()) {
                $this->estadoCivil  = $persona->getEstadoCivil();
            }
            if (!$persona->getPasatiemposHabilidades()->isEmpty()) {
                $this->pasatiemposHabilidades = $persona->getPasatiemposHabilidades();
            } else {
                $this->pasatiemposHabilidades = new ArrayCollection();
            }
        }
    }

    /**
     * @return Persona
     */
    public function getEntityData()
    {
        $persona = new Persona();
        $persona->setTercero($this->getTercero());
        $persona->setSexo($this->getSexo());
        $persona->setFechaNacimiento($this->getFechaNacimiento());
        $persona->setEdad($this->getEdad());
        $persona->setCedula($this->getCedula());
        $persona->setNombreMadre($this->getNombreMadre());
        $persona->setCedulaMadre($this->getCedulaMadre());
        $persona->setNombrePadre($this->getNombrePadre());
        $persona->setCedulaPadre($this->getCedulaPadre());
        $persona->setEmail($this->getEmail());
        $persona->setTallaCamiseta($this->getTallaCamiseta());
        $persona->setTallaPantalon($this->getTallaPantalon());
        $persona->setTallaShort($this->getTallaShort());
        $persona->setTrabaja($this->isTrabaja());
        if ($this->getProfesion() !== null) {
            $persona->setProfesion($this->getProfesion());
        }
        if ($this->getNacionalidad() !== null) {
            $persona->setNacionalidad($this->getNacionalidad());
        }
        if ($this->getIdioma1() !== null) {
            $persona->setIdioma1($this->getIdioma1());
        }
        if ($this->getIdioma2() !== null) {
            $persona->setIdioma2($this->getIdioma2());
        }
        if ($this->getEstadoCivil() !== null) {
            $persona->setEstadoCivil($this->getEstadoCivil());
        }
        if (!$this->getPasatiemposHabilidades()->isEmpty()) {
            foreach ($this->getPasatiemposHabilidades() as $pasatiempo) {
                $persona->addPasatiemposHabilidade($pasatiempo);
            }
        }

        return $persona;
    }

    /**
     * @return string
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @param string $cedula
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    /**
     * @return string
     */
    public function getCedulaMadre()
    {
        return $this->cedulaMadre;
    }

    /**
     * @param string $cedulaMadre
     */
    public function setCedulaMadre($cedulaMadre)
    {
        $this->cedulaMadre = $cedulaMadre;
    }

    /**
     * @return string
     */
    public function getCedulaPadre()
    {
        return $this->cedulaPadre;
    }

    /**
     * @param string $cedulaPadre
     */
    public function setCedulaPadre($cedulaPadre)
    {
        $this->cedulaPadre = $cedulaPadre;
    }

    /**
     * @return int
     */
    public function getEdad()
    {
        if (!$this->edad && $this->fechaNacimiento) {
            $fechaActual = new \DateTime();

            $diff = date_diff($this->fechaNacimiento, $fechaActual);
            $this->edad = $diff->y;
        }

        return $this->edad;
    }

    /**
     * @param int $edad
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
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
     * @return \Olimpiada\NomencladorBundle\Entity\NEstadoCivil
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * @param \Olimpiada\NomencladorBundle\Entity\NEstadoCivil $estadoCivil
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estadoCivil = $estadoCivil;
    }

    /**
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param \DateTime $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
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
     * @return \Olimpiada\NomencladorBundle\Entity\NIdioma
     */
    public function getIdioma1()
    {
        return $this->idioma1;
    }

    /**
     * @param \Olimpiada\NomencladorBundle\Entity\NIdioma $idioma1
     */
    public function setIdioma1($idioma1)
    {
        $this->idioma1 = $idioma1;
    }

    /**
     * @return \Olimpiada\NomencladorBundle\Entity\NIdioma
     */
    public function getIdioma2()
    {
        return $this->idioma2;
    }

    /**
     * @param \Olimpiada\NomencladorBundle\Entity\NIdioma $idioma2
     */
    public function setIdioma2($idioma2)
    {
        $this->idioma2 = $idioma2;
    }

    /**
     * @return \Olimpiada\NomencladorBundle\Entity\NNacionalidad
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * @param \Olimpiada\NomencladorBundle\Entity\NNacionalidad $nacionalidad
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;
    }

    /**
     * @return string
     */
    public function getNombreMadre()
    {
        return $this->nombreMadre;
    }

    /**
     * @param string $nombreMadre
     */
    public function setNombreMadre($nombreMadre)
    {
        $this->nombreMadre = $nombreMadre;
    }

    /**
     * @return string
     */
    public function getNombrePadre()
    {
        return $this->nombrePadre;
    }

    /**
     * @param string $nombrePadre
     */
    public function setNombrePadre($nombrePadre)
    {
        $this->nombrePadre = $nombrePadre;
    }

    /**
     * @return ArrayCollection
     */
    public function getPasatiemposHabilidades()
    {
        return $this->pasatiemposHabilidades;
    }

    /**
     * @param ArrayCollection $pasatiemposHabilidades
     */
    public function setPasatiemposHabilidades($pasatiemposHabilidades)
    {
        $this->pasatiemposHabilidades = $pasatiemposHabilidades;
    }

    /**
     * @return \Olimpiada\NomencladorBundle\Entity\NProfesion
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * @param \Olimpiada\NomencladorBundle\Entity\NProfesion $profesion
     */
    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;
    }

    /**
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param string $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return string
     */
    public function getTallaCamiseta()
    {
        return $this->tallaCamiseta;
    }

    /**
     * @param string $tallaCamiseta
     */
    public function setTallaCamiseta($tallaCamiseta)
    {
        $this->tallaCamiseta = $tallaCamiseta;
    }

    /**
     * @return string
     */
    public function getTallaPantalon()
    {
        return $this->tallaPantalon;
    }

    /**
     * @param string $tallaPantalon
     */
    public function setTallaPantalon($tallaPantalon)
    {
        $this->tallaPantalon = $tallaPantalon;
    }

    /**
     * @return string
     */
    public function getTallaShort()
    {
        return $this->tallaShort;
    }

    /**
     * @param string $tallaShort
     */
    public function setTallaShort($tallaShort)
    {
        $this->tallaShort = $tallaShort;
    }

    /**
     * @return \HatueyERP\TercerosBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }

    /**
     * @return boolean
     */
    public function isTrabaja()
    {
        return $this->trabaja;
    }

    /**
     * @param boolean $trabaja
     */
    public function setTrabaja($trabaja)
    {
        $this->trabaja = $trabaja;
    }

    /**
     * @return boolean
     */
    public function isIsPersona()
    {
        return $this->isPersona;
    }

    /**
     * @param boolean $isPersona
     */
    public function setIsPersona($isPersona)
    {
        $this->isPersona = $isPersona;
    }
} 