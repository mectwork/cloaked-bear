<?php

namespace Buseta\CoreBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class MonedaSimboloExtension extends \Twig_Extension
{

    private $em;
    private $session;

    function __construct(EntityManager $em, Session $session)
    {
        $this->em       = $em;
        $this->session  = $session;
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('moneda_simbolo', array($this, 'monedaSimbolo')),
        );
    }

    public function monedaSimbolo($number, $decimals = 2, $decPoint = '.', $thousandsSep = ' ')
    {
        if(!$this->session->has('moneda_simbolo')){
            $monedaActiva = $this->em->getRepository('BusetaNomencladorBundle:Moneda')->findOneBy(
                array(
                    'activo' => true,
                )
            );
            $simbolo = $monedaActiva->getSimbolo();
            $this->session->set('moneda_simbolo',$simbolo);
        }else{
            $simbolo = $this->session->get('moneda_simbolo');
        }

        $transform = number_format($number, $decimals, $decPoint, $thousandsSep);
        $transform = $simbolo.' '.$transform;

        return $transform;
    }

    public function getName()
    {
        return 'moneda_simbolo_extension';
    }
}