<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DespachadoraCombustible.
 *
 * @ORM\Table(name="d_despachadora_combustible")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\DespachadoraCombustibleRepository")
 */
class DespachadoraCombustible
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
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\ConfiguracionCombustible")
     */
    private $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadLibros", type="integer")
     * @Assert\NotBlank()
     */
    private $cantidadLibros;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Chofer")
     */
    private $chofer;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $updatedby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $deletedby;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->deleted = false;
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
     * Set createdby
     *
     * @param \Buseta\SecurityBundle\Entity\User $createdby
     * @return Chofer
     */
    public function setCreatedby(\Buseta\SecurityBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby
     *
     * @param \Buseta\SecurityBundle\Entity\User $updatedby
     * @return Chofer
     */
    public function setUpdatedby(\Buseta\SecurityBundle\Entity\User $updatedby = null)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set deletedby
     *
     * @param \Buseta\SecurityBundle\Entity\User $deletedby
     * @return Chofer
     */
    public function setDeletedby(\Buseta\SecurityBundle\Entity\User $deletedby = null)
    {
        $this->deletedby = $deletedby;

        return $this;
    }

    /**
     * Get deletedby
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Chofer
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Chofer
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Chofer
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set cantidadLibros
     *
     * @param integer $cantidadLibros
     * @return DespachadoraCombustible
     */
    public function setCantidadLibros($cantidadLibros)
    {
        $this->cantidadLibros = $cantidadLibros;
    
        return $this;
    }

    /**
     * Get cantidadLibros
     *
     * @return integer 
     */
    public function getCantidadLibros()
    {
        return $this->cantidadLibros;
    }

    /**
     * Set combustible
     *
     * @param \Buseta\BusesBundle\Entity\ConfiguracionCombustible $combustible
     * @return DespachadoraCombustible
     */
    public function setCombustible(\Buseta\BusesBundle\Entity\ConfiguracionCombustible $combustible = null)
    {
        $this->combustible = $combustible;
    
        return $this;
    }

    /**
     * Get combustible
     *
     * @return \Buseta\BusesBundle\Entity\ConfiguracionCombustible 
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set chofer
     *
     * @param \Buseta\BusesBundle\Entity\Chofer $chofer
     * @return DespachadoraCombustible
     */
    public function setChofer(\Buseta\BusesBundle\Entity\Chofer $chofer = null)
    {
        $this->chofer = $chofer;
    
        return $this;
    }

    /**
     * Get chofer
     *
     * @return \Buseta\BusesBundle\Entity\Chofer 
     */
    public function getChofer()
    {
        return $this->chofer;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return DespachadoraCombustible
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
}