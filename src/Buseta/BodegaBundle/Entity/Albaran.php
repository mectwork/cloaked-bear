<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Albaran
 *
 * @ORM\Table(name="d_albaran")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\AlbaranRepository")
 */
class Albaran
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
     * @ORM\Column(name="numero_documento", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $numero_documento;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="albaran")
     */
    private $tercero;
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
     * Set numero_documento
     *
     * @param string $numeroDocumento
     * @return Albaran
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numero_documento = $numeroDocumento;
    
        return $this;
    }

    /**
     * Get numero_documento
     *
     * @return string 
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * Set tercero
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     * @return Albaran
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;
    
        return $this;
    }

    /**
     * Get tercero
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }
}