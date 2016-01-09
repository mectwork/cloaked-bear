<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\GrupoBuses;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GrupoBusesFilterModel.
 */
class GrupoBusesFilterModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $color;

    /**
     * Constructor
     */
    public function __construct(GrupoBuses $grupobuses = null)
    {
        if ($grupobuses !== null) {
            $this->id = $grupobuses->getId();

            $this->nombre = $grupobuses->getNombre();
            $this->color = $grupobuses->getColor();

        }
    }

    /**
     * @return GrupoBuses
     */
    public function getEntityData()
    {
        $grupobuses = new GrupoBuses();
        $grupobuses->setNombre($this->getNombre());
        $grupobuses->setColor($this->getColor());

        return $grupobuses;
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
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

}
