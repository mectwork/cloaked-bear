<?php

namespace HatueySoft\SecurityBundle\EventListener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;

/**
 * Class RoleListener
 *
 * @package HatueySoft\SecurityBundle\EventListener
 */
class RoleListener
{
    /**
     * @var string
     */
    protected  $scope;

    /**
     * @var Container
     */
    protected $container;

    /**
     * RoleListener constructor.
     *
     * @param string             $scope
     * @param ContainerInterface $container
     */
    public function __construct($scope, ContainerInterface $container)
    {
        $this->scope = $scope;
        $this->container = $container;
    }

    /**
     * Trigger command process and logoff the user token from the Security Context
     */
    public function onRoleSave()
    {
        $kernel = $this->container->get('kernel');
        $env = $kernel->getEnvironment();

        $process = new Process(sprintf('php ../app/console cache:clear -e %s', $env));
        $process->run();

        if ($process->isSuccessful()) {
            $this->container->get('security.token_storage')->getToken()->setAuthenticated(false);
            $this->container->get('security.token_storage')->getToken()->eraseCredentials();
            $this->container->get("request")->getSession()->invalidate();
            $this->container->get('security.token_storage')->setToken(null);
        }
    }
}
