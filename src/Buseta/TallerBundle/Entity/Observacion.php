<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Observacion
 *
 * @ORM\Table(name="d_observacion")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\ObservacionRepository")
 */
class Observacion
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
     * @ORM\Column(name="valor", type="string", nullable=true)
     */
    private $valor;

    /**
     * @var \Buseta\TallerBundle\Entity\Reporte
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Reporte", inversedBy="observaciones")
     */
    private $reporte;

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
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
     * Set reporte
     *
     * @param \Buseta\TallerBundle\Entity\Reporte $reporte
     * @return Observacion
     */
    public function setReporte(\Buseta\TallerBundle\Entity\Reporte $reporte = null)
    {
        $this->reporte = $reporte;
    
        return $this;
    }

    /**
     * Get reporte
     *
     * @return \Buseta\TallerBundle\Entity\Reporte 
     */
    public function getReporte()
    {
        return $this->reporte;
    }
}