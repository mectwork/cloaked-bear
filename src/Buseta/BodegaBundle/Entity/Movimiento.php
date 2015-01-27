<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimiento
 *
 * @ORM\Table(name="d_movimiento")
 * @ORM\Entity
 */
class Movimiento
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenDestino;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="movimientos")
     */
    private $producto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadMovido", type="integer")
     */
    private $cantidadMovido;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaMovimiento", type="date")
     */
    private $fechaMovimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="movidoBy", type="string", nullable=true)
     */
    private $movidoBy;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", nullable=true)
     */
    private $createdBy;

    /**
     * @var date
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedBy", type="string", nullable=true)
     */
    private $updatedBy;

}