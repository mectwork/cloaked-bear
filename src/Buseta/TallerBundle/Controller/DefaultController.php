<?php

namespace Buseta\TallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Module Taller entiy.
     */
    public function principalAction()
    {
        return $this->render('BusetaTallerBundle:Default:principal.html.twig');
    }
}
