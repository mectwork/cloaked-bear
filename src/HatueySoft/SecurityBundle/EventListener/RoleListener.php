<?php
/**
 * Created by PhpStorm.
 * User: firomero
 * Date: 10/10/14
 * Time: 12:19
 */

namespace HatueySoft\SecurityBundle\EventListener;

use HatueySoft\SecurityBundle\Event\GetRoleEvents;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;


class RoleListener {

    protected  $scope;

    /**
     * @var Process\ProcessBuilder
     */
    protected $builder;

    /**
     * @var Container
     */
    protected $container;

    public function __construct($scope, Container $container)
    {
        $this->scope = $scope;
        $this->builder = new Process\ProcessBuilder();
        $this->container = $container;
    }

    public function onRoleSave(GetRoleEvents $event)
    {
        $kernel = $this->container->get('kernel');
        $env = $kernel->getEnvironment();

        $input = new StringInput(sprintf('cache:clear --env=%s', $env));
        $application = new Application($kernel);

        if ($application->run($input) === 0) {
            $this->container->get('security.context')->getToken()->setAuthenticated(false);
            $this->container->get('security.context')->getToken()->eraseCredentials();
            $this->container->get("request")->getSession()->invalidate();
            $this->container->get('security.context')->setToken(null);
        }
    }
} 