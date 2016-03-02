<?php

namespace Buseta\CombustibleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Marchamo2Valido
 *
 * @package Buseta\CombustibleBundle\Validator\Constraints
 * @Annotation
 */
class Marchamo2Valido extends Constraint
{
    public $messageCantidad = 'No es posible extraer Marchamo de bodega, no existen cantidades disponibles.';
    public $messageSerial = 'El Marchamo con número de serie "%serial%" no existe en bodega.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'combustible_marchamo2valido_validador';
    }
}
