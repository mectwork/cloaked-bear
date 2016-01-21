<?php

namespace Buseta\BodegaBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidarMaxMinValidator extends ConstraintValidator
{
    private $security;
    private $em;

    function __construct(SecurityContext $security, EntityManager $em)
    {
        $this->security = $security;
        $this->em       = $em;
    }

    public function validate($entity, Constraint $constraint)
    {
        /*  @var  \Buseta\BodegaBundle\Entity\ProductoTope  $entity*/

        $min = $entity->getMin();
        $max = $entity->getMax();

        if ($min > $max) {
            $this->context->addViolationAt(
                'max',
                $constraint->message,
                array('%string%' => 'El valor maximo debe ser mayor que el minimo')
            );
         }
    }
}



