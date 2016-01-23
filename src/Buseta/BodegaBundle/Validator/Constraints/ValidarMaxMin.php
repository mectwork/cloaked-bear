<?php

namespace Buseta\BodegaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ValidarMaxMin
 * @package Buseta\BodegaBundle\Validator\Constraints
 * @Annotation
 */
class ValidarMaxMin extends Constraint
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
        return 'validar_maxmin_validator';
    }
}
