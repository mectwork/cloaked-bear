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

    public function renderProgressBar(\Twig_Environment $twig, MantenimientoPreventivo $entity)
    {
        $percentage = $this->mpem->getPorciento($this->em, $entity);

        $query = $this->em->createQuery(
            'SELECT t.color
            FROM BusetaNomencladorBundle:MantenimientoPorcientoCumplido t
            WHERE t.porciento >= :porciento
            ORDER BY t.porciento ASC')
            ->setMaxResults(1)
            ->setParameter('porciento', $percentage);

        $color = $query->getOneOrNullResult();

        if ($color === null) {
            $color = array('color' => '#5bc0de');
        }

        return $twig->render('::progressbar.html.twig', array(
                'percentage' => $percentage,
                'color' => $color['color'],
            ));
    }

    public function getName()
    {
        return 'progress_bar_render_extension';
    }
}
