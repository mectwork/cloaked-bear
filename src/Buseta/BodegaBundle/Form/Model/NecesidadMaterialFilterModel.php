<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NecesidadMaterial Model
 *
 */
class NecesidadMaterialFilterModel
{

    /**
     * @var string
     */
    private $numero_documento;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     * @Assert\NotBlank()
     */
    private $almacen;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Moneda
     * @Assert\NotBlank()
     */
    private $moneda;

    /**
     * @var \Buseta\NomencladorBundle\Entity\FormaPago
     * @Assert\NotBlank()
     */
    private $forma_pago;

    /**
     * @var \Buseta\TallerBundle\Entity\CondicionesPago
     * @Assert\NotBlank()
     */
    private $condiciones_pago;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $estado_documento;


    /**
     * @return mixed
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @param mixed $almacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

    /**
     * @return \Buseta\TallerBundle\Entity\CondicionesPago
     */
    public function getCondicionesPago()
    {
        return $this->condiciones_pago;
    }

    /**
     * @param \Buseta\TallerBundle\Entity\CondicionesPago $condiciones_pago
     */
    public function setCondicionesPago($condiciones_pago)
    {
        $this->condiciones_pago = $condiciones_pago;
    }

    /**
     * @return mixed
     */
    public function getEstadoDocumento()
    {
        return $this->estado_documento;
    }

    /**
     * @param mixed $estado_documento
     */
    public function setEstadoDocumento($estado_documento)
    {
        $this->estado_documento = $estado_documento;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\FormaPago
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $forma_pago
     */
    public function setFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Moneda $moneda
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
    }

    /**
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * @param string $numero_documento
     */
    public function setNumeroDocumento($numero_documento)
    {
        $this->numero_documento = $numero_documento;
    }

    /**
     * @return mixed
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param mixed $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
}
