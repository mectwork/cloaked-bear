<?php

namespace HatueyERP\TercerosBundle\Form\Model;


use HatueyERP\TercerosBundle\Entity\Cliente;

class ClienteModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $isCliente;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;


    /**
     * @param Cliente $cliente
     */
    function __construct(Cliente $cliente = null)
    {
        if ($cliente) {
            $this->id = $cliente->getId();
            $this->isCliente = true;
            $this->tercero = $cliente->getTercero();
        }
    }

    /**
     * @return Cliente
     */
    public function getEntityData()
    {
        $cliente = new Cliente();
        $cliente->setTercero($this->getTercero());

        return $cliente;
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
    public function isIsCliente()
    {
        return $this->isCliente;
    }

    /**
     * @param boolean $isCliente
     */
    public function setIsCliente($isCliente)
    {
        $this->isCliente = $isCliente;
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