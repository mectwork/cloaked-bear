<?php

namespace Buseta\BodegaBundle\Interfaces;


interface UserAwareInterface
{
    /**
     * Sets the created by user
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface|null $user A user instance or null
     */
    public function setCreatedBy(\Symfony\Component\Security\Core\User\UserInterface $user = null);

    /**
     * Sets the updated by user
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface|null $user A user instance or null
     */
    public function setUpdatedBy(\Symfony\Component\Security\Core\User\UserInterface $user = null);
}
