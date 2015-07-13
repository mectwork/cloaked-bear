<?php

namespace Buseta\CombustibleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BusetaCombustibleBundle:Default:index.html.twig', array('name' => $name));
    }
}
