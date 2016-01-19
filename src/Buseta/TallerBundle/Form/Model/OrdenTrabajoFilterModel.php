<?php
namespace Buseta\TallerBundle\Form\Model;

use Doctrine\ORM\Mapping as ORM;

class OrdenTrabajoFilterModel
{
    /**
     * @var \Buseta\TallerBundle\Entity\Diagnostico
     */
    private $diagnostico;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $ayudante;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $autobus;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $requisionMateriales;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $diagnosticadoPor;

    /**
     *
     * @var \Buseta\BusesBundle\Entity\GrupoBuses
     */
    private $grupobuses;


    /**
     * @return \Buseta\TallerBundle\Entity\Diagnostico
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * @param \Buseta\TallerBundle\Entity\Diagnostico $diagnostico
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;
    }

    /**
     * @return mixed
     */
    public function getAyudante()
    {
        return $this->ayudante;
    }

    /**
     * @param mixed $ayudante
     */
    public function setAyudante($ayudante)
    {
        $this->ayudante = $ayudante;
    }

    /**
     * @return mixed
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param mixed $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getRequisionMateriales()
    {
        return $this->requisionMateriales;
    }

    /**
     * @param string $requisionMateriales
     */
    public function setRequisionMateriales($requisionMateriales)
    {
        $this->requisionMateriales = $requisionMateriales;
    }

    /**
     * @return mixed
     */
    public function getDiagnosticadoPor()
    {
        return $this->diagnosticadoPor;
    }

    /**
     * @param mixed $diagnosticadoPor
     */
    public function setDiagnosticadoPor($diagnosticadoPor)
    {
        $this->diagnosticadoPor = $diagnosticadoPor;
    }


    /**
     * @return \Buseta\BusesBundle\Entity\GrupoBuses
     */
    public function getGrupoBuses()
    {
        return $this->grupobuses;
    }


    /**
     * @param $grupobuses
     * @return $this
     */
    public function setGrupoBuses($grupobuses)
    {
        $this->grupobuses = $grupobuses;

        return $this;
    }
}