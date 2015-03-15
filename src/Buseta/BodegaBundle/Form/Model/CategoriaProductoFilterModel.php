<?php
namespace Buseta\BodegaBundle\Form\Model;

class CategoriaProductoFilterModel
{
    /**
     * @var string
     */
    private $valor;

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }
} 