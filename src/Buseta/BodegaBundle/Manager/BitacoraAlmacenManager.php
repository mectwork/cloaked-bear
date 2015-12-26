<?php

namespace Buseta\BodegaBundle\Manager;


use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator;
use Symfony\Bridge\Monolog\Logger;

class BitacoraAlmacenManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param Validator $validator
     */
    function __construct(ObjectManager $em, Logger $logger, Validator $validator)
    {
        $this->em               = $em;
        $this->logger           = $logger;
        $this->validator        = $validator;
    }

   public function createRegistry(BitacoraAlmacen $bitacora)
   {
           try {

                   //el validator valida por los assert de la entity
                   $validationOrigen = $this->validator->validate($bitacora);
                   if ($validationOrigen->count() === 0) {
                       $this->em->persist($bitacora);
                   } else {
                      $errors = '';
                     foreach ($validationOrigen->getIterator() as $param => $error) {
                          $errors .= sprintf('%s: %s. ', $param, $error);
                     }
                      $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));
                     return false;
                   }

               //punto clave
               //aqui es donde se guarda en la base de datos
               //debe garantizarse una transaccion con rollback si hay fallo
               //y se le informa al usuario, la pregunta se hace en el manager!!!!!,
               // el cual retorna true o false al controlador
               //y desde el controlador se conoce el resultado y se informa a usuario
               //ver aqui como garantizar la transaccion!!!!!!!!!!!!!!!!!
               $this->em->flush();

               return true;

           } catch (\Exception $e) {
               $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));
                //hacer rollback en el futuro
               return false;
           }

   }

    /*public function createRegistry(GeneradorBitacoraInterface $generadorbitacora, $tipomovimiento)
    {
            try {
                    $nuevabitacoraOrigen= New BitacoraAlmacen();
                    $nuevabitacoraOrigen->setAlmacen($generadorbitacora->getBitacoraAlmacenOrigen());
                    $nuevabitacoraOrigen->setProducto($generadorbitacora->getBitacoraProducto());
                    $nuevabitacoraOrigen->setCantidadMovida($generadorbitacora->getBitacoraCantidadMovida());
                    $nuevabitacoraOrigen->setFechaMovimiento($generadorbitacora->getBitacoraFechaMovimiento());
                    $nuevabitacoraOrigen->setTipoMovimiento($tipomovimiento);
                    $idLineas = $generadorbitacora->getBitacoraIdsLinea();
                    $nuevabitacoraOrigen->setMovimientoLinea($idLineas['movLinea']);
                    $nuevabitacoraOrigen->setEntradaSalidaLinea($idLineas['entLinea']);
                    $nuevabitacoraOrigen->setInventarioLinea($idLineas['invLinea']);
                    $nuevabitacoraOrigen->setProduccionLinea($idLineas['proLinea']);

                    //el validator valida por los assert de la entity
                    $validationOrigen = $this->validator->validate($nuevabitacoraOrigen);
                    if ($validationOrigen->count() === 0) {
                        $this->em->persist($nuevabitacoraOrigen);
                    } else {
                       $errors = '';
                      foreach ($validationOrigen->getIterator() as $param => $error) {
                           $errors .= sprintf('%s: %s. ', $param, $error);
                      }
                       $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));
                      return false;
                    }

                //genero movimiento hacia si existe almacen de destino
                if (!is_null( $generadorbitacora->getBitacoraAlmacenDestino() )){
                    $nuevabitacoraDestino = $nuevabitacoraOrigen->clonar();
                    //solo cambiar el almacen destino
                    $nuevabitacoraDestino->setAlmacen($generadorbitacora->getBitacoraAlmacenDestino());

                    //el validator valida por los assert de la entity
                    $validationDestino = $this->validator->validate($nuevabitacoraDestino);
                    if ($validationDestino->count() === 0) {
                        $this->em->persist($nuevabitacoraDestino);
                    } else {
                        $errors = '';
                        foreach ($validationDestino->getIterator() as $param => $error) {
                            $errors .= sprintf('%s: %s. ', $param, $error);
                        }
                        $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));
                        return false;
                    }

                }

                //punto clave
                //aqui es donde se guarda en la base de datos
                //debe garantizarse una transaccion con rollback si hay fallo
                //si se informa hacia atras el stoppropagation significaria que hubo error
                //y se le informa al usuario, la pregunta se hace en el manager!!!!!,
                // el cual retorna true o false al controlador
                //y desde el controlador se conoce el resultado y se informa a usuario
                //ver aqui como garantizar la transaccion!!!!!!!!!!!!!!!!!
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));
                 //hacer rollback en el futuro
                return false;
            }

    }*/
}
