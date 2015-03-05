<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 3/03/15
 * Time: 20:38
 */

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reporte
 *
 * @ORM\Table(name="d_reporte")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\ReporteRepository")
 */
class Reporte
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", nullable=false)
     */
    private $numero;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     * @Assert\NotNull
     */
    private $autobus;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NMedioReporte")
     * @Assert\NotNull
     */
    private $medioReporte;

    /**
     * @ORM\Column(name="es_usuario", type="boolean", nullable=true)
     */
    private $esUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_persona", type="string", nullable=true)
     */
    private $nombrePersona;

    /**
     * @var string
     *
     * @ORM\Column(name="email_persona", type="string", nullable=true)
     */
    private $emailPersona;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_persona", type="string", nullable=true)
     */
    private $telefonoPersona;









    

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
     * Set numero
     *
     * @param string $numero
     * @return Reporte
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set esUsuario
     *
     * @param boolean $esUsuario
     * @return Reporte
     */
    public function setEsUsuario($esUsuario)
    {
        $this->esUsuario = $esUsuario;
    
        return $this;
    }

    /**
     * Get esUsuario
     *
     * @return boolean 
     */
    public function getEsUsuario()
    {
        return $this->esUsuario;
    }

    /**
     * Set nombrePersona
     *
     * @param string $nombrePersona
     * @return Reporte
     */
    public function setNombrePersona($nombrePersona)
    {
        $this->nombrePersona = $nombrePersona;
    
        return $this;
    }

    /**
     * Get nombrePersona
     *
     * @return string 
     */
    public function getNombrePersona()
    {
        return $this->nombrePersona;
    }

    /**
     * Set emailPersona
     *
     * @param string $emailPersona
     * @return Reporte
     */
    public function setEmailPersona($emailPersona)
    {
        $this->emailPersona = $emailPersona;
    
        return $this;
    }

    /**
     * Get emailPersona
     *
     * @return string 
     */
    public function getEmailPersona()
    {
        return $this->emailPersona;
    }

    /**
     * Set telefonoPersona
     *
     * @param string $telefonoPersona
     * @return Reporte
     */
    public function setTelefonoPersona($telefonoPersona)
    {
        $this->telefonoPersona = $telefonoPersona;
    
        return $this;
    }

    /**
     * Get telefonoPersona
     *
     * @return string 
     */
    public function getTelefonoPersona()
    {
        return $this->telefonoPersona;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return Reporte
     */
    public function setAutobus(\Buseta\BusesBundle\Entity\Autobus $autobus = null)
    {
        $this->autobus = $autobus;
    
        return $this;
    }

    /**
     * Get autobus
     *
     * @return \Buseta\BusesBundle\Entity\Autobus 
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * Set medioReporte
     *
     * @param \Buseta\NomencladorBundle\Entity\NMedioReporte $medioReporte
     * @return Reporte
     */
    public function setMedioReporte(\Buseta\NomencladorBundle\Entity\NMedioReporte $medioReporte = null)
    {
        $this->medioReporte = $medioReporte;
    
        return $this;
    }

    /**
     * Get medioReporte
     *
     * @return \Buseta\NomencladorBundle\Entity\NMedioReporte 
     */
    public function getMedioReporte()
    {
        return $this->medioReporte;
    }
}