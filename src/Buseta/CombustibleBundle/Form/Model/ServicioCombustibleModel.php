<?php

namespace Buseta\CombustibleBundle\Form\Model;

use Buseta\BusesBundle\Entity\Chofer;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Buseta\CombustibleBundle\Form\Model\ChoferInServicioCombustible;
use Doctrine\ORM\Mapping as ORM;

use Buseta\BusesBundle\Validator\Constraints as BusetaBusesAssert;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ServicioCombustibleModel
 * @BusetaBusesAssert\CapacidadTanqueValido
 */
class ServicioCombustibleModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\CombustibleBundle\Entity\ConfiguracionCombustible
     */
    private $combustible;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $cantidadLibros;

    /**
     * @var ChoferInServicioCombustible
     * @Assert\Valid
     */
    private $chofer;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @var \DateTime
     *
     */
    private $created;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     */
    private $updated;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     */
    private $updatedby;

    /**
     * @var boolean
     *
     */
    private $deleted;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     */
    private $deletedby;

    /**
     * @return ServicioCombustible
     */
    public function getEntityData()
    {
        $servicioCombustible = new ServicioCombustible();
        $servicioCombustible->setCantidadLibros($this->getCantidadLibros());
        $servicioCombustible->setCreated($this->getCreated());
        $servicioCombustible->setCreatedby($this->getCreatedby());
        $servicioCombustible->setDeleted($this->getDeleted());
        $servicioCombustible->setDeletedby($this->getDeletedby());
        $servicioCombustible->setUpdated($this->getUpdated());
        $servicioCombustible->setUpdatedby($this->getUpdatedby());

        if ($this->getCombustible() !== null) {
            $servicioCombustible->setCombustible($this->getCombustible());
        }
        if ($this->getChofer() !== null) {
            $servicioCombustible->setChofer($this->getChofer()->getChofer());
        }
        if ($this->getAutobus() !== null) {
            $servicioCombustible->setAutobus($this->getAutobus());
        }

        return $servicioCombustible;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * @param \Buseta\SecurityBundle\Entity\User $createdby
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * @param \Buseta\SecurityBundle\Entity\User $updatedby
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;
    }

    /**
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }

    /**
     * @param \Buseta\SecurityBundle\Entity\User $deletedby
     */
    public function setDeletedby($deletedby)
    {
        $this->deletedby = $deletedby;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return ConfiguracionCombustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param ConfiguracionCombustible $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return int
     */
    public function getCantidadLibros()
    {
        return $this->cantidadLibros;
    }

    /**
     * @param int $cantidadLibros
     */
    public function setCantidadLibros($cantidadLibros)
    {
        $this->cantidadLibros = $cantidadLibros;
    }

    /**
     * @param mixed $chofer
     */
    public function setChofer($chofer)
    {
        if($chofer instanceof ChoferInServicioCombustible){
            $this->chofer = $chofer;
        }else if($chofer instanceof Chofer){
            $choferInServicioCombustible = new ChoferInServicioCombustible();
            $choferInServicioCombustible->setChofer($chofer);
            $this->chofer = $choferInServicioCombustible;
        }
    }

    /**
     * @return ChoferInServicioCombustible
     */
    public function getChofer()
    {
        return $this->chofer;
    }

    /**
     * @return Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

}