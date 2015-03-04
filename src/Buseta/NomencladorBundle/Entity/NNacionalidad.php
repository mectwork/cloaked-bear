<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Buseta\NomencladorBundle\Models\NomencladorAbstractClass;

/**
 * @author: dundivet <dundivet@emailn.de>
 *
 * @ORM\Table(name="n_nacionalidad")
 * @ORM\Entity
 */
class NNacionalidad extends NomencladorAbstractClass
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
