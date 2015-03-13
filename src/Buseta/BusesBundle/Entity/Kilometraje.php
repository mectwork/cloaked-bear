<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Kilometraje
 *
 * @ORM\Table(name="c_kilometraje")
 * @ORM\Entity
 */
class Kilometraje
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
     * @var integer
     *
     * @ORM\Column(name="valor", type="integer", columnDefinition="INT( 11 ) NOT NULL DEFAULT '0'")
     * @Assert\Type("integer")
     */
    private $valor;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     *
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="kilometraje")
     * @ORM\JoinColumn(name="autobus_id")
     *
     * @Assert\NotNull
     */
    private $autobus;

    /**
     * @return Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
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
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

}