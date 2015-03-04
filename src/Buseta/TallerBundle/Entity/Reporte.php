<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 3/03/15
 * Time: 20:38
 */

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reporte
 *
 * @ORM\Table(name="d_reporte")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\ReporteRepository")
 */
class Reporte
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", nullable=false)
     */
    private $numero;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     * @Assert\NotNull
     */
    private $autobus;



    
} 