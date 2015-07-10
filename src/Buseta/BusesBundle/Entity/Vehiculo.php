<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vehiculo.
 *
 * @ORM\Table(name="d_vehiculo")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\VehiculoRepository")
 */
class Vehiculo extends BaseVehiculo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
