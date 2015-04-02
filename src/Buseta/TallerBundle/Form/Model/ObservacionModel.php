<?php

namespace Buseta\TallerBundle\Form\Model;


use Buseta\TallerBundle\Entity\Observacion;

class ObservacionModel implements ReportesModelInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\TallerBundle\Entity\Reporte
     */
    private $reporte;

    /**
     * @var string
     */
    private $valor;


    /**
     * @param Observacion $observacion
     */
    function __construct(Observacion $observacion = null)
    {
        if ($observacion) {
            $this->id       = $observacion->getId();
            $this->valor    = $observacion->getValor();

            if ($observacion->getReporte()) {
                $this->reporte = $observacion->getReporte();
            }
        }
    }

    /**
     * @return Observacion
     */
    function getEntityData()
    {
        $observacion = new Observacion();
        $observacion->setValor($this->getValor());
        $observacion->setReporte($this->getReporte());

        return $observacion;
    }

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
     * @return \Buseta\TallerBundle\Entity\Reporte
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * @param \Buseta\TallerBundle\Entity\Reporte $reporte
     */
    public function setReporte($reporte)
    {
        $this->reporte = $reporte;
    }
}