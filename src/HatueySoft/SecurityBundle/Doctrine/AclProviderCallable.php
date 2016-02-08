<?php

namespace HatueySoft\SecurityBundle\Doctrine;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AclProviderCallable
 *
 * @package HatueySoft\SecurityBundle\Doctrine
 */
class AclProviderCallable
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * AclProviderCallable constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $object
     * @param $method
     *
     * @return mixed|\Symfony\Component\Security\Acl\Model\MutableAclInterface
     *
     * @throws \Exception
     * @throws \Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException
     */
    public function __invoke($object, $method)
    {
        if ($method === 'create') {
            return $this->container->get('security.acl.provider')->createAcl($object);
        } elseif ($method === 'update') {
            return $this->container->get('security.acl.provider')->updateAcl($object);
        } elseif($method === 'delete') {
            return $this->container->get('security.acl.provider')->deleteAcl($object);
        }
    }
}
