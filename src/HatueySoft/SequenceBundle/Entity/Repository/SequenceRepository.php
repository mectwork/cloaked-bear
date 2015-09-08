<?php

namespace HatueySoft\SequenceBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use HatueySoft\SequenceBundle\Form\Model\SecuenciaFilterModel;
use Doctrine\ORM\NoResultException;

/**
 * SequenceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SequenceRepository extends EntityRepository
{
    public function filter(SecuenciaFilterModel $filter = null)
    {
        $qb = $this->createQueryBuilder('s');
        $query = $qb->where($qb->expr()->eq(true,true));

        if($filter) {
            if ($filter->getNombre() !== null && $filter->getNombre() !== '') {
                $query->andWhere($qb->expr()->like('s.nombre',':nombre'))
                    ->setParameter('nombre', '%' . $filter->getNombre() . '%');
            }
            if ($filter->getTipo() !== null && $filter->getTipo() !== '') {
                $query->andWhere($query->expr()->eq('s.tipo', ':tipo'))
                    ->setParameter('tipo', $filter->getTipo());
            }
            if ($filter->getPrefijo() !== null && $filter->getPrefijo() !== '') {
                $query->andWhere($qb->expr()->like('s.prefijo',':prefijo'))
                    ->setParameter('prefijo', '%' . $filter->getPrefijo() . '%');
            }
            if ($filter->getSufijo() !== null && $filter->getSufijo() !== '') {
                $query->andWhere($qb->expr()->like('s.sufijo',':sufijo'))
                    ->setParameter('sufijo', '%' . $filter->getSufijo() . '%');
            }
        }

        $query->orderBy('s.id', 'ASC');

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }

    public function isActive($name)
    {
        $qb = $this->createQueryBuilder('s');
        $query = $qb->select('s.active')
            ->where($qb->expr()->eq('s.name', ':name'))
            ->setParameter('name', $name)
            ->getQuery();

        try {
            $result = $query->getSingleResult();

            return $result['active'];
        } catch (\Exception $e) {
            return false;
        }
    }
}
