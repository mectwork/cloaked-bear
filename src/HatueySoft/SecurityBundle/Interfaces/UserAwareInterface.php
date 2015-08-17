<?php

namespace BusBPM\CoreBundle\Entity;

interface UserAwareInterface
{
    /**
     * Sets the created by user
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $createdBy A user instance
     */
    public function setCreatedBy(\HatueySoft\SecurityBundle\Entity\User $createdBy);

    /**
     * Sets the updated by user
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $updatedBy A user instance
     */
    public function setUpdatedBy(\HatueySoft\SecurityBundle\Entity\User $updatedBy);
}
