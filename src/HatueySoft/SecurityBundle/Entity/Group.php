<?php

namespace HatueySoft\SecurityBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author: firomero <firomerorom4@gmail.com>
 * @author: dundivet <dundivet@emailn.de>
 *
 * @ORM\Entity
 * @ORM\Table(name="hatueysoft_security_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
