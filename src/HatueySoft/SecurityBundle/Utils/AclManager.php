<?php

namespace HatueySoft\SecurityBundle\Utils;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Util\ClassUtils;

class AclManager
{
    /**
     * @var \HatueySoft\SecurityBundle\Doctrine\AclProviderCallable
     */
    private $aclProviderCallable;

    /**
     * @var \HatueySoft\SecurityBundle\Doctrine\UserCallable
     */
    private $userCallable;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    function __construct(ContainerInterface $container)
    {
        $this->aclProviderCallable  = $container->get('hatuey_soft.acl_provider_callable');
        $this->logger               = $container->get('logger');
        $this->userCallable         = $container->get('hatuey_soft.security.user_callable');
    }

    /**
     * Establece las reglas de ACL para el objeto.
     *
     * @param $object
     * @param array $applyTo
     * @throws \Exception
     * @throws \Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException
     * @throws \Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException
     */
    public function setAcl($object, $applyTo = array())
    {
        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        $aclProviderCallable = $this->aclProviderCallable;
        $acl = $aclProviderCallable($objectIdentity, 'create');

        $this->applyAcl($acl, $applyTo);
    }

    /**
     * Actualiza la acl del objeto en cuestión.
     *
     * @param $object
     * @param array $applyTo
     * @throws \Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException
     */
    public function updateAcl($object, $applyTo=array())
    {
        $objectIdentity = ObjectIdentity::fromDomainObject($object);

        $aclProviderCallable = $this->aclProviderCallable;
        $aclProviderCallable($objectIdentity, 'delete');
        $acl = $aclProviderCallable($objectIdentity, 'create');

        $this->applyAcl($acl, $applyTo);
    }

    /**
     * Aplica y actualiza las reglas de la ACL
     *
     * @param $acl
     * @param $applyTo
     */
    private function applyAcl($acl, $applyTo)
    {
        $aclProviderCallable = $this->aclProviderCallable;

        if (isset($applyTo['users'])) {
            foreach ($applyTo['users'] as $username => $mask) {
                if ($user = $this->findUserByUsername($username)) {
                    $securityIdentity = UserSecurityIdentity::fromAccount($user);

                    $acl->insertObjectAce($securityIdentity, $this->getMask($mask));
                } else {
                    $this->logger->addAlert(sprintf('No es posible adicionar ACL para el usuario \'%s\', el mismo no pudo ser encontrado.', $username));
                }
            }
        }

        if (isset($applyTo['roles'])) {
            foreach ($applyTo['roles'] as $role => $mask) {
                $securityIdentity = new RoleSecurityIdentity($role);

                $acl->insertObjectAce($securityIdentity, $this->getMask($mask));
            }
        }
        $aclProviderCallable($acl, 'update');
    }

    /**
     * Devuelve entero para la mascara de ACL.
     *
     * @param $arrayMask
     * @return int
     */
    public function getMask($arrayMask)
    {
        $builder = new MaskBuilder();
        foreach ($arrayMask as $value) {
            $builder->add(strtolower($value));
        }

        return $builder->get();
    }

    /**
     * Devuelve el usuario dado el nombre de usuario
     *
     * @param $username
     * @return bool|\HatueySoft\SecurityBundle\Entity\User
     */
    private function findUserByUsername($username)
    {
        $userCallable = $this->userCallable;

        return $userCallable->findByUsername($username);
    }
}
