<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MecanismoContacto.
 *
 * @ORM\Table(name="d_mecanismo_contacto")
 * @ORM\Entity
 */
class MecanismoContacto
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
     * @var \Buseta\NomencladorBundle\Entity\TipoContacto
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\TipoContacto")
     */
    private $tipocontacto;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="mecanismosContacto")
     */
    private $tercero;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string")
     */
    private $valor;

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
     * Set valor.
     *
     * @param string $valor
     *
     * @return MecanismoContacto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set tipocontacto.
     *
     * @param \Buseta\NomencladorBundle\Entity\TipoContacto $tipocontacto
     *
     * @return MecanismoContacto
     */
    public function setTipocontacto(\Buseta\NomencladorBundle\Entity\TipoContacto $tipocontacto = null)
    {
        $this->tipocontacto = $tipocontacto;

        return $this;
    }

    /**
     * Get tipocontacto.
     *
     * @return \Buseta\NomencladorBundle\Entity\TipoContacto
     */
    public function getTipocontacto()
    {
        return $this->tipocontacto;
    }

    /**
     * Set tercero.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     *
     * @return MecanismoContacto
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }
}
