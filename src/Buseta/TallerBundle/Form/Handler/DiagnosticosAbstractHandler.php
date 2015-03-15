<?php

namespace Buseta\TallerBundle\Form\Handler;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class DiagnosticosAbstractHandler
{
    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    protected $trans;

    /**
     * @var boolean
     */
    protected $error;


    function __construct(ContainerInterface $container)
    {
        $this->formFactory  = $container->get('form.factory');
        $this->logger       = $container->get('logger');
        $this->em           = $container->get('doctrine.orm.entity_manager');
        $this->router       = $container->get('router');
        $this->session      = $container->get('session');
        $this->trans        = $container->get('translator');
        $this->error        = false;
    }

    /**
     * @return boolean
     */
    public abstract function handle();

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return boolean
     */
    public function getError()
    {
        return $this->error;
    }
} 