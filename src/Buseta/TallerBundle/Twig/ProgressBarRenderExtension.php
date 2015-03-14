<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 11/03/15
 * Time: 19:49.
 */

namespace Buseta\TallerBundle\Twig;

use Buseta\TallerBundle\Entity\MantenimientoPreventivo;
use Buseta\TallerBundle\Manager\MantenimientoPreventivoManager;
use Doctrine\ORM\EntityManager;

class ProgressBarRenderExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MantenimientoPreventivoManager
     */
    private $mpem;

    public function __construct(EntityManager $em, MantenimientoPreventivoManager $mpem)
    {
        $this->em = $em;
        $this->mpem = $mpem;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('progress_bar_render', array($this, 'renderProgressBar'), array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )),
        );
    }

    public function renderProgressBar(\Twig_Environment $twig, $mpreventivo_id)
    {
        $entity = $this->em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->find($mpreventivo_id);
        $result = $this->mpem->getPorciento($this->em, $entity);

        return $twig->render('::progressbar.html.twig', array(
            'percentage' => $result['porcentage'],
            'color' => $result['color'],
        ));
    }

    public function getName()
    {
        return 'progress_bar_render_extension';
    }
}
