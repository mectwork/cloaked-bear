<?php

namespace HatueySoft\SecurityBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueSystemUserEmail extends Constraint
{
    public $message = 'El email "%email%" ya se encuentra registrado en el sistema.';

    public function validatedBy()
    {
        return 'unique_systemuser_email_validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
