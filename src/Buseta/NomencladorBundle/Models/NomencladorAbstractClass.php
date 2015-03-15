<?php
/**
 * This file is part of BusetaNomencladorBundle
 *
 * (c) dundivet <dundivet@emailn.de>
 *
 */

namespace Buseta\NomencladorBundle\Models;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields={"nombre"})
 */
abstract class NomencladorAbstractClass
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    protected $nombre;

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    public function __toString()
    {
        return $this->nombre;
    }
} 