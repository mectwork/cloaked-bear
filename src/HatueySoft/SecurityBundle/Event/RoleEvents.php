<?php
/**
 * Created by PhpStorm.
 * User: firomero
 * Date: 10/10/14
 * Time: 12:10
 */

namespace HatueySoft\SecurityBundle\Event;


final class RoleEvents {
    /**
     * Lanzado al crear un rol
     * El listener recibirá una instancia de HatueySoft\SecurityBundle\Event\GetRoleEvent
     *
     */
    const ROLE_SAVE = 'hatuey_soft_security.role_save';
} 