<?php
/**
 * Created by PhpStorm.
 * User: anierm
 * Date: 22/12/15
 * Time: 21:27
 */

namespace Buseta\TallerBundle\Event;


final class OrdenTrabajoEvents
{
    //const PROCESAR_ORDEN = 'buseta.taller.orden.procesar';

    const PROCESAR_DIAGNOSTICO = 'buseta.taller.diagnostico.procesarreporte';

    const CAMBIAR_CANCELADO = 'buseta.taller.orden.cambiarcancelado';

    const CAMBIAR_ESTADO_ABIERTO = 'buseta.taller.orden.cambiarestadoabierto';

    const CAMBIAR_ESTADO_CERRADO = 'buseta.taller.orden.cambiarestadocerrado';

    const CAMBIAR_ESTADO_COMPLETADO = 'buseta.taller.orden.cambiarestadocompletado';


}
