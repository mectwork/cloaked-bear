<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Color.
 *
 * @ORM\Table(name="n_moneda")
 * @ORM\Entity(repositoryClass="Buseta\NomencladorBundle\Entity\MonedaRepository")
 * @UniqueEntity(fields={"activo"}, repositoryMethod="onlyOneActive", message="Ya se encuentra registrada una Moneda activa.")
 */
class Moneda extends BaseNomenclador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="simbolo", type="string", length=1)
     * @Assert\NotBlank
     */
    private $simbolo;

    /**
     * @var boolean
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return string
     */
    public function getSimbolo()
    {
        return $this->simbolo;
    }

    /**
     * @param string $simbolo
     */
    public function setSimbolo($simbolo)
    {
        $this->simbolo = $simbolo;
    }
}
