<?php

namespace Buseta\BusesBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\PropertyAccess\StringUtil;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ExecutionContextInterface;

class CapacidadTanqueValidoValidator extends ConstraintValidator
{
    private $security;
    private $em;

    function __construct(SecurityContext $security, EntityManager $em)
    {
        $this->security = $security;
        $this->em       = $em;
    }


    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($data, Constraint $constraint)
    {
        //capacidad de combustible del autobus
        $capacidadCombustible = $data->getAutobus()->getCapacidadTanque();

        //Validando que la capacidadTanque del Autobus sea mayor o igual la cantidadLibros entrada
        if ($capacidadCombustible <= $data->getCantidadLibros()) {
            $this->context->addViolationAt('cantidadLibros', $constraint->messageCantidadLibros, array());
        }

        return;
    }
}