<?php

namespace Buseta\BodegaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ValidarSerial
 * @package Buseta\BodegaBundle\Validator\Constraints
 * @Annotation
 */
class ValidarSerial extends Constraint
{
    public $message = '%string%';


    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'validar_serial_validator';
    }
}
