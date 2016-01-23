<?php

namespace HatueySoft\SecurityBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueSystemUserUsername extends Constraint
{
    public $message = 'El usuario "%username%" ya se encuentra registrado en el sistema.';

    public function validatedBy()
    {
        return 'unique_systemuser_username_validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
