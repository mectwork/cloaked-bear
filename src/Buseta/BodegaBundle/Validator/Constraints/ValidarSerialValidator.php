<?php

namespace Buseta\BodegaBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Buseta\BodegaBundle\Extras\GeneradorSeriales;
use Symfony\Component\Security\Core\Util\ClassUtils;

class ValidarSerialValidator extends ConstraintValidator
{
    private $security;
    private $em;

    /**
     * @var \Buseta\BodegaBundle\Extras\GeneradorSeriales
     */
    private $generadorSeriales;

    function __construct(SecurityContext $security, EntityManager $em, GeneradorSeriales $generadorSeriales)
    {
        $this->security = $security;
        $this->em = $em;
        $this->generadorSeriales = $generadorSeriales;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint)
    {

        if ($entity->getSeriales() !== null) {

            $ocurrioError = false;
            $error = '';
            $seriales = $this->generadorSeriales->getListaDeSeriales($entity->getSeriales());

            //validar luego si el producto debe tener numero de serie no puede tener entonces
            //ningun dato en el campo serial.
            /*if ($entity->getProducto() !== null && $entity->getProducto()->getTieneNroSerie()) {
            }*/

            switch (ClassUtils::getRealClass($entity)) {

                case 'Buseta\BodegaBundle\Entity\AlbaranLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\AlbaranLinea */
                    if ($seriales) {
                        //verificar si la cantidad movida coincide con el numero de seriales entrado
                        if (count($seriales) !== $entity->getCantidadMovida()) {
                            $ocurrioError = true;
                            $error = 'La cantidad real no coincide con el numero de seriales';
                        }
                        //Si llega aqui todoo bien y no hay errores y termino
                    } else {
                        //si llega aqui es que hubo un error de validacion del serial
                        $ocurrioError = true;
                        $error = $this->generadorSeriales->getLasterror();
                    }

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\InventarioFisicoLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\InventarioFisicoLinea */
                    if ($seriales) {
                        //verificar si la cantidad real coincide con el numero de seriales entrado
                        if (count($seriales) !== $entity->getCantidadReal()) {
                            $ocurrioError = true;
                            $error = 'La cantidad real no coincide con el numero de seriales';
                        }
                        //Si llega aqui todoo bien y no hay errores y termino
                    } else {
                        //si llega aqui es que hubo un error de validacion del serial
                        $ocurrioError = true;
                        $error = $this->generadorSeriales->getLasterror();
                    }
                    break;
                }

                case 'Buseta\BodegaBundle\Entity\MovimientosProductos': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\MovimientosProductos */
                    break;
                }
                case 'Buseta\BodegaBundle\Entity\SalidaBodegaProducto': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\SalidaBodegaProducto */
                    break;
                }
                case 'Buseta\CombustibleBundle\Entity\ServicioCombustible': {
                    /* @var  $entity \Buseta\CombustibleBundle\Entity\ServicioCombustible */
                    break;
                }
                default:
                    break;
            }


            if ($ocurrioError) {
                $this->context->addViolationAt(
                    'seriales',
                    $constraint->message,
                    array('%string%' => $error)
                );
            }


        }

    }
}



