<?php

namespace Buseta\NotificacionesBundle\Manager;

use Buseta\NotificacionesBundle\Entity\Notificacion;
use Buseta\NotificacionesBundle\NotificacionesVars;
use Doctrine\ORM\EntityManager;
use HatueySoft\SecurityBundle\Entity\User as Usuario;
use Doctrine\ORM\NoResultException;

class NotificacionesManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var NotificacionesInternaManager
     */
    private $internaManager;

    /**
     * @var NotificacionesCorreoManager
     */
    private $correoManager;

    /**
     * @var array
     */
    private $defaultNotificacion;

    function __construct(EntityManager $em, NotificacionesInternaManager $internaManager, NotificacionesCorreoManager $correoManager)
    {
        $this->em                   = $em;
        $this->internaManager       = $internaManager;
        $this->correoManager        = $correoManager;
        $this->defaultNotificacion  = NotificacionesVars::getDefaultNotificacion();
    }

    /**
     * Genera una notificación genérica a partir de un cuerpo entrado por parámetro
     *
     * @return bool
     */
    public function generateNotificacionGenerica($cuerpo)
    {
        //notificaciones por correo
        try{
            $this->correoManager->sendCorreos(
                'notificacion_generica',
                array(
                    'cuerpo' => $cuerpo,
                ));
        }catch (\Exception $e){
            //print_r($e->getMessage());exit;
            //notificar en caso de lanzar excepcion
        }

        //notificaciones internas
        try{
            $this->internaManager->sendNotificaciones(
                'notificacion_generica',
                array(
                    'cuerpo' => $cuerpo,
                ));
        }catch (\Exception $e){
            //print_r($e->getMessage());exit;
            //notificar en caso de lanzar excepcion
        }
        return true;
    }

    /**
     * Genera los datos para el reporte de boletas pendientes en caja para la fecha entrada por parámetros
     *
     * @param $date
     * @return bool
     */
/*    public function generateBoletaPendienteCaja($date)
    {
        //buscando boletas pendientes para la fecha $date
        $boletas = $this->em->getRepository('BusetaCoreBundle:Boleta')->getBoletasPendientesByDate($date);
        if($boletas)
        {
            //notificaciones por correo
            try{
                $correo = $this->correoManager->sendCorreos(
                    'boleta_pendiente_caja',
                    array(
                        'boletas' => $boletas,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());
                //notificar en caso de lanzar excepcion
            }

            //notificaciones internas
            try{
                $notificaciones = $this->internaManager->sendNotificaciones(
                    'boleta_pendiente_caja',
                    array(
                        'boletas' => $boletas,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());
                //notificar en caso de lanzar excepcion
            }
        }
        return true;
    }*/

    /**
     * Genera el reporte para los casos cajero pendientes en la fecha entrada por parámetros
     *
     * @param $date
     * @return bool
     */
/*    public function generateCasocajeroPendienteBarra($date)
    {
        //buscando casos cajero pendientes para la fecha $date
        $casos = $this->em->getRepository('BusetaCoreBundle:CasoCajero')->getCasosPendientesByDate($date);
        if($casos)
        {
            //notificaciones por correo
            try{
                $correo = $this->correoManager->sendCorreos(
                    'casocajero_pendiente_barra',
                    array(
                        'casoscajero' => $casos,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }

            //notificaciones internas
            try{
                $notificaciones = $this->internaManager->sendNotificaciones(
                    'casocajero_pendiente_barra',
                    array(
                        'casoscajero' => $casos,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }
        }
        return true;
    }*/

    /**
     * Genera los datos para el reporte de adelantos en la fecha entrada por parámetros
     *
     * @param \DateTime $date
     * @return bool
     */
/*    public function generateAdelantosReport(\DateTime $date)
    {
        //buscando casos cajero pendientes para la fecha $date
        $adelantos = $this->em->getRepository('BusetaCoreBundle:AdelantoSalario')->findAdelantosByDate($date);
        if($adelantos)
        {
            //notificaciones por correo
            try{
                $correo = $this->correoManager->sendCorreos(
                    'reporte_adelantos',
                    array(
                        'adelantos' => $adelantos,
                        'fecha' => $date,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }

            //notificaciones internas
            try{
                $notificaciones = $this->internaManager->sendNotificaciones(
                    'reporte_adelantos',
                    array(
                        'adelantos' => $adelantos,
                        'fecha' => $date,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }
        }
        return true;
    }*/

    /**
     * Genera los datos para el reporte de deudas pendientes históricas
     *
     * @return bool
     */
    /*public function generateDeudasPendientesReport()
    {
        //buscando casos cajero pendientes para la fecha $date
        $deudas = $this->em->getRepository('BusetaCoreBundle:ListaNegraReposicion')->findDeudasPendientes();
        if($deudas)
        {
            //notificaciones por correo
            try{
                $correo = $this->correoManager->sendCorreos(
                    'reporte_deudas_pendientes',
                    array(
                        'deudas' => $deudas,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }

            //notificaciones internas
            try{
                $notificaciones = $this->internaManager->sendNotificaciones(
                    'reporte_deudas_pendientes',
                    array(
                        'deudas' => $deudas,
                    ));
            }catch (\Exception $e){
                //print_r($e->getMessage());exit;
                //notificar en caso de lanzar excepcion
            }
        }
        return true;
    }*/

}
