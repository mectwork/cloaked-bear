<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 11/03/15
 * Time: 20:35
 */

namespace Buseta\TallerBundle\Manager;

use Buseta\TallerBundle\Entity\MantenimientoPreventivo;
use Doctrine\ORM\EntityManager;

class MantenimientoPreventivoManager
{

    /**
     * @param EntityManager $em
     * @param MantenimientoPreventivo $entity
     * @return mixed
     */
    public function getPorciento(EntityManager $em, MantenimientoPreventivo $entity)
    {
        $repository = $em->getRepository('BusetaTallerBundle:TareaAdicional');
        $qb = $repository->createQueryBuilder('dta');

        $query = $qb->select(array('dot.kilometraje'))
            ->innerJoin('dta.ordenTrabajo', 'dot')
            ->andWhere($qb->expr()->eq('dta.tarea', ':tarea'))
            ->andWhere($qb->expr()->eq('dta.grupo', ':grupo'))
            ->andWhere($qb->expr()->eq('dta.subgrupo', ':subgrupo'))
            ->andWhere($qb->expr()->eq('dot.autobus', ':autobus'))
            ->setParameters(array(
                'tarea' => $entity->getTarea(),
                'grupo' => $entity->getGrupo(),
                'subgrupo' => $entity->getSubgrupo(),
                'autobus' => $entity->getAutobus()
            ))
            ->orderBy('dot.fechaFinal')
            ->setMaxResults(1);

        $query = $query->getQuery();

        $mantenimientoKilometraje = $entity->getKilometraje();
        $busKilometraje = $entity->getAutobus()->getKilometraje();

        $result = $query->getOneOrNullResult();

        if ($result !== null) {
            $busKilometraje = $busKilometraje - $result['kilometraje'];
        }

        $porcientoKilometraje = 100.0 * $busKilometraje / $mantenimientoKilometraje;

        return $porcientoKilometraje;
    }
} 