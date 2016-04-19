<?php
/**
 * Created by PhpStorm.
 * User: kalandraka
 * Date: 4/18/2016
 * Time: 11:35 AM
 */

namespace Buseta\CombustibleBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ServerExposeExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return array(
           'server' => $this->container->getParameter('buseta_combustible.server')
        );
    }

    public function getName()
    {
        return 'server_expose_extension';
    }
}