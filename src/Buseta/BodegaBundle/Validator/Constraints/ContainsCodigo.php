<?php

namespace Buseta\BodegaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsCodigo
 * @package Buseta\BodegaBundle\Validator\Constraints
 * @Annotation
 */
class ContainsCodigo extends Constraint
{
    public $message = 'El código ATSA: %string% ya está en uso.';


    /**
     * @return string
     */
    public function getTargets()
    {
    return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'contains_codigo_validator';
    }
}
