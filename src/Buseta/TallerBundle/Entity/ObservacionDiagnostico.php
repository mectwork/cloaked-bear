<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ObservacionDiagnostico
 *
 * @ORM\Table(name="d_observacion_diagnostico")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\ObservacionDiagnosticoRepository")
 */
class ObservacionDiagnostico
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
     * @var \Buseta\TallerBundle\Entity\Diagnostico
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Diagnostico", inversedBy="observaciones")
     */
    private $diagnostico;

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
     * Set diagnostico
     *
     * @param \Buseta\TallerBundle\Entity\Diagnostico $diagnostico
     * @return ObservacionDiagnostico
     */
    public function setDiagnostico(\Buseta\TallerBundle\Entity\Diagnostico $diagnostico = null)
    {
        $this->diagnostico = $diagnostico;
    
        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return \Buseta\TallerBundle\Entity\Diagnostico 
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }
}