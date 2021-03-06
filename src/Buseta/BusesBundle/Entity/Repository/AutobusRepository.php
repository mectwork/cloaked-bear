<?php

namespace Buseta\BusesBundle\Entity\Repository;

use Buseta\BusesBundle\Form\Model\AutobusFilterModel;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * AutobusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AutobusRepository extends EntityRepository
{
    public function filter(AutobusFilterModel $filter = null)
    {
        $qb = $this->createQueryBuilder('a');
        $query = $qb->where($qb->expr()->eq(true,true));

        if($filter) {
            if ($filter->getMatricula() !== null && $filter->getMatricula() !== '') {
                $query->andWhere($qb->expr()->like('a.matricula',':matricula'))
                    ->setParameter('matricula', '%' . $filter->getMatricula() . '%');
            }
            if ($filter->getNumero() !== null && $filter->getNumero() !== '') {
                $query->andWhere($qb->expr()->like('a.numero',':numero'))
                    ->setParameter('numero', '%' . $filter->getNumero() . '%');
            }
            if ($filter->getMarca() !== null && $filter->getMarca() !== '') {
                $query->andWhere($query->expr()->eq('a.marca', ':marca'))
                    ->setParameter('marca', $filter->getMarca());
            }
            if ($filter->getEstilo() !== null && $filter->getEstilo() !== '') {
                $query->andWhere($query->expr()->eq('a.estilo', ':estilo'))
                    ->setParameter('estilo', $filter->getEstilo());
            }
            if ($filter->getColor() !== null && $filter->getColor() !== '') {
                $query->andWhere($query->expr()->eq('a.color', ':color'))
                    ->setParameter('color', $filter->getColor());
            }
            if ($filter->getMarcaMotor() !== null && $filter->getMarcaMotor() !== '') {
                $query->andWhere($query->expr()->eq('a.marcaMotor', ':marcaMotor'))
                    ->setParameter('marcaMotor', $filter->getMarcaMotor());
            }
        }

        $query->orderBy('a.id', 'ASC');

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }
}
