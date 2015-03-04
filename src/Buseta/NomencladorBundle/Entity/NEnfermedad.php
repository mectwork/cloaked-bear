<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Buseta\NomencladorBundle\Models\NomencladorAbstractClass;

/**
 * NEnfermedad
 *
 * @ORM\Table(name="n_enfermedad")
 * @ORM\Entity
 */
class NEnfermedad extends NomencladorAbstractClass
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
