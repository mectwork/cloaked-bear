<?php
namespace Buseta\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=64)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=64)
     */
    private $apellidos;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"persist", "remove"})
     */
    private $foto;

    public function __construct()
    {
        parent::__construct();
    }
}
