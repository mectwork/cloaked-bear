<?php

namespace HatueySoft\SecurityBundle\Doctrine;

use Doctrine\ORM\Mapping as ORM;

trait UserAwareTrait
{
    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="createdby_id")
     */
    private $createdBy;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="updatedby_id")
     */
    private $updatedBy;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="deletedby_id")
     */
    private $deletedBy;


    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $createdBy
     */
    public function setCreatedBy(\HatueySoft\SecurityBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $updatedBy
     */
    public function setUpdatedBy(\HatueySoft\SecurityBundle\Entity\User $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $deletedBy
     */
    public function setDeletedBy(\HatueySoft\SecurityBundle\Entity\User $deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
}
