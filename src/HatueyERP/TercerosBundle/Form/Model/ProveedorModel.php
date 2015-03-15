<?php

namespace HatueyERP\TercerosBundle\Form\Model;


use HatueyERP\TercerosBundle\Entity\Proveedor;

class ProveedorModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var boolean
     */
    private $isProveedor;


    /**
     * Constructor
     */
    function __construct(Proveedor $proveedor = null)
    {
        if($proveedor != null) {
            $this->id           = $proveedor->getId();
            $this->isProveedor  = true;
            if ($proveedor->getTercero() !== null) {
                $this->tercero      = $proveedor->getTercero();
            }
        }
    }

    /**
     * @return Proveedor
     */
    public function getEntityData()
    {
        $proveedor = new Proveedor();
        $proveedor->setTercero($this->getTercero());

        return $proveedor;
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
     * @return boolean
     */
    public function isIsProveedor()
    {
        return $this->isProveedor;
    }

    /**
     * @param boolean $isProveedor
     */
    public function setIsProveedor($isProveedor)
    {
        $this->isProveedor = $isProveedor;
    }

    /**
     * @return \HatueyERP\TercerosBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
} 