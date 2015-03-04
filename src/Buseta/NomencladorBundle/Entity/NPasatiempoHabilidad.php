<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Buseta\NomencladorBundle\Models\NomencladorAbstractClass;

/**
 * NPasatiempoHabilidad
 *
 * @ORM\Table(name="n_pasatiempo_habilidad")
 * @ORM\Entity
 */
class NPasatiempoHabilidad extends NomencladorAbstractClass
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
