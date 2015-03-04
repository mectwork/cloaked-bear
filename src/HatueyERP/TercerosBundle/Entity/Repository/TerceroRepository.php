<?php

namespace HatueyERP\TercerosBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use HatueyERP\TercerosBundle\Form\Model\TerceroFilterModel;

class TerceroRepository extends EntityRepository
{
    public function filter(TerceroFilterModel $filter = null)
    {
        $qb = $this->createQueryBuilder('t');
        $query = $qb->where($qb->expr()->eq(true,true));

        if($filter) {
            if ($filter->getIdentificador() !== null && $filter->getIdentificador() !== '') {
                $query->andWhere($qb->expr()->like('t.identificador',':identificador'))
                    ->setParameter('identificador', '%' . $filter->getIdentificador() . '%');
            }
            if ($filter->getNombres() !== null && $filter->getNombres() !== '') {
                $query->andWhere($qb->expr()->like('t.nombres',':nombres'))
                    ->setParameter('nombres', '%' . $filter->getNombres() . '%');
            }
            if ($filter->getApellidos() !== null && $filter->getApellidos() !== '') {
                $query->andWhere($qb->expr()->like('t.apellidos',':apellidos'))
                    ->setParameter('apellidos', '%' . $filter->getApellidos() . '%');
            }
        }

        $query->orderBy('t.id', 'ASC');

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }
} 