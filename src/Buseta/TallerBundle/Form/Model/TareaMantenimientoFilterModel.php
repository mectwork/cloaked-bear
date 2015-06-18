<?php
namespace Buseta\TallerBundle\Form\Model;

class TareaMantenimientoFilterModel
{
    /**
     * @var \Buseta\NomencladorBundle\Entity\Tarea
     */
    private $valor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    private $subgrupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\GarantiaTarea
     */
    private $garantia;

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     */
    public function setSubgrupo($subgrupo)
    {
        $this->subgrupo = $subgrupo;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\GarantiaTarea
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\GarantiaTarea $garantia
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    }

}