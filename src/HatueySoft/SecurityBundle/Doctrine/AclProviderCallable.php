<?php

namespace HatueySoft\SecurityBundle\Doctrine;


use Symfony\Component\DependencyInjection\ContainerInterface;

class AclProviderCallable
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $object
     * @param $method
     * @throws \Exception
     * @throws \Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException
     */
    public function __invoke($object, $method)
    {
        if ($method === 'create') {
            return $this->container->get('security.acl.provider')->createAcl($object);
        } elseif ($method === 'update') {
            $this->container->get('security.acl.provider')->updateAcl($object);
        } elseif($method === 'delete') {
            $this->container->get('security.acl.provider')->deleteAcl($object);
        }
    }
} 