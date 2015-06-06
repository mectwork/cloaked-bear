<?php

namespace Buseta\BodegaBundle\Twig;

use Buseta\NomencladorBundle\Entity\FormaPago;
use Doctrine\ORM\EntityManager;

class TagRenderExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FormaPago
     */

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tag_render', array($this, 'renderTag'), array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )),
        );
    }

    public function renderTag(\Twig_Environment $twig, $forma_pago_id)
    {
        $entity = $this->em->getRepository('BusetaNomencladorBundle:FormaPago')->find($forma_pago_id);

        return $twig->render('::tag.html.twig', array(
            'valor' => $entity->getValor(),
        ));
    }

    public function getName()
    {
        return 'tag_render_extension';
    }
}
