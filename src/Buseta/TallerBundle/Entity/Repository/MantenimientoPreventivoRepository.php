<?php

namespace Buseta\TallerBundle\Entity\Repository;

use Buseta\TallerBundle\Form\Model\MantenimientoPreventivoFilterModel;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class MantenimientoPreventivoRepository extends EntityRepository
{
    public function filter(MantenimientoPreventivoFilterModel $filter = null)
    {
        $query = $this->createQueryBuilder('mp');

        if ($filter) {
            if ($filter->getGrupo() !== null && $filter->getGrupo() !== '') {
                $query->innerJoin('mp.grupo', 'ng')
                    ->andWhere($query->expr()->like('ng.valor', ':grupo'))
                    ->setParameter('grupo', '%'.$filter->getGrupo().'%');
            }
            if ($filter->getSubgrupo() !== null && $filter->getSubgrupo() !== '') {
                $query->innerJoin('mp.subgrupo', 'ns')
                    ->andWhere($query->expr()->like('ns.valor', ':subgrupo'))
                    ->setParameter('subgrupo', '%'.$filter->getSubgrupo().'%');
            }
            if ($filter->getTarea() !== null && $filter->getTarea() !== '') {
                $query->innerJoin('mp.tarea', 'nt')
                    ->andWhere($query->expr()->like('nt.valor', ':tarea'))
                    ->setParameter('tarea', '%'.$filter->getTarea().'%');
            }
            if ($filter->getAutobus() !== null && $filter->getAutobus() !== '') {
                $query->innerJoin('mp.autobus', 'ta')
                    ->andWhere($query->expr()->like('ta.matricula', ':autobus'))
                    ->setParameter('autobus', '%'.$filter->getAutobus().'%');
            }

            $query->orderBy('mp.id', 'ASC');
        }

        try {
            return $query->getQuery();
        } catch (NoResultException $ex) {
            return array();
        }
    }
}
