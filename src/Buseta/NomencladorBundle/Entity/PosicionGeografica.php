<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 20/03/15
 * Time: 20:58
 */

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PosicionGeografica.
 *
 * @ORM\Table(name="n_posicion_geografica")
 * @ORM\Entity
 */
class PosicionGeografica extends BaseNomenclador
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud", type="decimal")
     */
    private $longitud;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud", type="decimal")
     */
    private $latitud;


    public function __toString()
    {
        return sprintf('%s [%f,%f]', $this->valor, $this->longitud, $this->latitud);
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set longitud
     *
     * @param string $longitud
     * @return PosicionGeografica
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    
        return $this;
    }

    /**
     * Get longitud
     *
     * @return string 
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set latitud
     *
     * @param string $latitud
     * @return PosicionGeografica
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    
        return $this;
    }

    /**
     * Get latitud
     *
     * @return string 
     */
    public function getLatitud()
    {
        return $this->latitud;
    }
}