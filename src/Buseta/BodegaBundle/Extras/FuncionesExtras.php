<?php

namespace Buseta\BodegaBundle\Extras;

use Buseta\TallerBundle\Entity\Impuesto;
use Doctrine\DBAL\Types\FloatType;


class FuncionesExtras
{

    public function ImporteLinea($impuesto, $cantidad_pedido, $precio_unitario, $porciento_descuento)
    {
        $importeLinea = 0;

        if($impuesto){
            $tipoImpuesto   = $impuesto->getTipo();
            $tarifaImpuesto = $impuesto->getTarifa();

            if($tipoImpuesto == "fijo")
            {
                $importeLinea     = ($cantidad_pedido * $precio_unitario) + $tarifaImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea     = $importeLinea - $importeDescuento;
            }
            elseif($tipoImpuesto == "porcentaje")
            {
                $importeImpuesto  = ($cantidad_pedido * $precio_unitario) * $tarifaImpuesto / 100;
                $importeLinea     = ($cantidad_pedido * $precio_unitario) + $importeImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea     = $importeLinea - $importeDescuento;
            }
        }

        return $importeLinea;
    }
}
?>