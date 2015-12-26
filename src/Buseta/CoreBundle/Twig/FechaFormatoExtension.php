<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/12/15
 * Time: 14:10
 */

namespace Buseta\CoreBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;


class FechaFormatoExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('fecha_formato', array($this, 'fechaFormato')),
        );
    }

    public function fechaFormato( $fecha )
    {
/*        if(!$this->session->has('fecha_formato')){
            $monedaActiva = $this->em->getRepository('BusetaNomencladorBundle:Moneda')->findOneBy(
                array(
                    'activo' => true,
                )
            );
            $simbolo = $monedaActiva->getSimbolo();
            $this->session->set('fecha_formato',$simbolo);
        }else{
            $simbolo = $this->session->get('fecha_formato');
        }*/

        if(!$this->session->has('fecha_formato')){
            $format = 'd-m-Y///h:i a';

            $this->session->set('fecha_formato', $format );
        } else {
            $format = $this->session->get('fecha_formato');
        }

        $transform = date_format($fecha, $format);

        return $transform;
    }

    public function getName()
    {
        return 'fecha_formato_extension';
    }
}