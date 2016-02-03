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

    public function __invoke()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        if (null !== $token) {
            return $token->getUser();
        }
    }

    /**
     * Devuelve el usuario dado el nombre de usuario
     *
     * @param $username
     * @return bool|\HatueySoft\SecurityBundle\Entity\User
     */
    public function findByUsername($username)
    {
        $user = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('HatueySoftSecurityBundle:User')
            ->findOneBy(array('username' => $username));

        if(!$user) {
            $this->container->get('logger')
                ->addCritical(sprintf('No es posible obtener el usuario \'%s\'', $username));

            return false;
        }

        return $user;
    }
}
