<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\PersonaModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="d_persona")
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
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="persona")
     * @ORM\JoinColumn(onDelete="CASCADE", name="tercero_id")
     */
    private $tercero;


    /**
     * Establece los valores desde el modelo en la entidad.
     *
     * @param PersonaModel $model
     *
     * @return $this
     */
    public function setModelData(PersonaModel $model)
    {
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
     * Set tercero
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     * @return Persona
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
