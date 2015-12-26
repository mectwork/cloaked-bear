<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarcaProveedor.
 *
 * @ORM\Table(name="n_marca_proveedor")
 * @ORM\Entity
 */
class MarcaProveedor
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
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="Buseta\BodegaBundle\Entity\Proveedor", mappedBy="marcas")
     */
    private $proveedores;

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return MarcaProveedor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->proveedores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add proveedores.
     *
     * @param \Buseta\BodegaBundle\Entity\Proveedor $proveedores
     *
     * @return MarcaProveedor
     */
    public function addProveedore(\Buseta\BodegaBundle\Entity\Proveedor $proveedores)
    {
        $this->proveedores[] = $proveedores;

        return $this;
    }

    /**
     * Remove proveedores.
     *
     * @param \Buseta\BodegaBundle\Entity\Proveedor $proveedores
     */
    public function removeProveedore(\Buseta\BodegaBundle\Entity\Proveedor $proveedores)
    {
        $this->proveedores->removeElement($proveedores);
    }

    /**
     * Get proveedores.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProveedores()
    {
        return $this->proveedores;
    }
}
