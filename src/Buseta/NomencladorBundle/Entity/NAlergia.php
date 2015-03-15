<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Buseta\NomencladorBundle\Models\NomencladorAbstractClass;

/**
 * NAlergia
 *
 * @ORM\Table(name="n_alergia")
 * @ORM\Entity
 */
class NAlergia extends NomencladorAbstractClass
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
