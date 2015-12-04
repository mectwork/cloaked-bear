<?php

namespace HatueySoft\SecurityBundle\EventListener;

use HatueySoft\SecurityBundle\Event\GetRoleEvents;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;


class RoleListener
{
    protected  $scope;

    /**
     * @var Container
     */
    protected $container;

    public function __construct($scope, Container $container)
    {
        $this->scope = $scope;
        $this->container = $container;
    }

    public function onRoleSave(GetRoleEvents $event)
    {
        $kernel = $this->container->get('kernel');
        $env = $kernel->getEnvironment();

        $process = new Process(sprintf('php ../app/console cache:clear -e %s', $env));
        $process->run();

        if ($process->isSuccessful()) {
            $this->container->get('security.context')->getToken()->setAuthenticated(false);
            $this->container->get('security.context')->getToken()->eraseCredentials();
            $this->container->get("request")->getSession()->invalidate();
            $this->container->get('security.context')->setToken(null);
        }
    }
}
