<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ModuloCombustible.
 *
 * @ORM\Table(name="d_modulo_combustible")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\ModuloCombustibleRepository")
 */
class ModuloCombustible
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
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\ConfiguracionCombustible")
     */
    private $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadLibros", type="integer")
     * @Assert\NotBlank()
     */
    private $cantidadLibros;


}