<?php

namespace Buseta\CombustibleBundle\Exception;


class ServicioCombustibleException extends \Exception
{
    public static final function UndefinedMarchamoConfiguration()
    {
        return new self('No se ha definido una configuración válida activa para Marchamo.');
    }

    public static final function UndefinedCombustibleConfiguration()
    {
        return new self('No se ha definido una configuración válida activa para Combustible.');
    }
}
