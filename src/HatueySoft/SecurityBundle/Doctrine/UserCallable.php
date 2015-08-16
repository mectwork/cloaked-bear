<?php

namespace HatueySoft\SecurityBundle\Doctrine;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UserCallable
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
     * Devuelve el usuario dado el nombre de usuario
     *
     * @param $username
     * @return bool|\HatueySoft\SecurityBundle\Entity\EUsuario
     */
    public function __invoke($username)
    {
        $user = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('HatueySoftSecurityBundle:EUsuario')
            ->findOneBy(array('username' => $username));

        if(!$user) {
            $this->container->get('logger')
                ->addCritical(sprintf('No es posible obtener el usuario \'%s\'', $username));

            return false;
        }

        return $user;
    }
}