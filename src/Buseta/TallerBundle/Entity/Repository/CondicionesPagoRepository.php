<?php

namespace Buseta\TallerBundle\Entity\Repository;

use Buseta\TallerBundle\Form\Model\CondicionesPagoFilterModel;
use Doctrine\ORM\EntityRepository;

/**
 * CondicionesPagoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CondicionesPagoRepository extends EntityRepository
{
    public function filter(CondicionesPagoFilterModel $filter = null)
    {
        $qb = $this->createQueryBuilder('c');
        $query = $qb->where($qb->expr()->eq(true,true));

        if($filter) {
            if ($filter->getNombre() !== null && $filter->getNombre() !== '') {
                $query->andWhere($qb->expr()->like('c.nombre',':nombre'))
                    ->setParameter('nombre', '%' . $filter->getNombre() . '%');
            }
            if ($filter->getDiasPlazo() !== null && $filter->getDiasPlazo() !== '') {
                $query->andWhere($qb->expr()->like('c.dias_plazo',':dias_plazo'))
                    ->setParameter('dias_plazo', '%' . $filter->getDiasPlazo() . '%');
            }
            if ($filter->getMesesPlazo() !== null && $filter->getMesesPlazo() !== '') {
                $query->andWhere($qb->expr()->like('c.meses_plazo',':meses_plazo'))
                    ->setParameter('meses_plazo', '%' . $filter->getMesesPlazo() . '%');
            }
        }

        $query->orderBy('c.id', 'ASC');

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }

    public function searchByValor($valores) {
        $q = "SELECT r FROM BusetaTallerBundle:CondicionesPago r WHERE r.id = :valores";

        $query = $this->_em->createQuery($q);
        $query->setParameter('valores', $valores);

        try {
            return $query->getResult();
        } catch (NoResultException $e) {
            return false;
        }
    }
}
