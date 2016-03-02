<?php

namespace Buseta\CombustibleBundle\Event\BitacoraSerial;


use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Event\BitacoraSerial\AbstractBitacoraSerialEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Buseta\CombustibleBundle\Event\BitacoraBodega\BitacoraServicioCombustibleEvent;
use Symfony\Component\Security\Core\Util\ClassUtils;

class BitacoraSerialServicioCombustibleEvent extends AbstractBitacoraSerialEvent
{
    /**
     * @var BitacoraServicioCombustibleEvent
     */
    private $servicioCombustibleEvent;

    /**
     * BitacoraSerialServicioCombustibleEvent constructor.
     *
     * @param BitacoraServicioCombustibleEvent $servicioCombustibleEvent
     */
    public function __construct(BitacoraServicioCombustibleEvent $servicioCombustibleEvent=null)
    {
        if (null === $servicioCombustibleEvent) {
            return;
        }

        parent::__construct($servicioCombustibleEvent->isFlush());

        if ($servicioCombustibleEvent->getBitacoraEvents()->count() > 0) {
            $this->servicioCombustibleEvent = $servicioCombustibleEvent;

            $fillBitacoraSerialEvents = function (BitacoraEventModel $servicioCombustibleEventLinea, $serial) {
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($servicioCombustibleEventLinea->getWarehouse());
                $bitacoraSerialEvent->setProduct($servicioCombustibleEventLinea->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($servicioCombustibleEventLinea->getMovementDate());
                $bitacoraSerialEvent->setMovementType($servicioCombustibleEventLinea->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($servicioCombustibleEventLinea) {
                    $servicioCombustible = $servicioCombustibleEventLinea->getReferencedObject();
                    $bitacoraSerial->setConsumoInterno(sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($servicioCombustible),
                        $servicioCombustible->getId()
                    ));
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($servicioCombustibleEvent->getBitacoraEvents() as $servicioCombustibleEventLinea) {
                /** @var BitacoraEventModel $servicioCombustibleEventLinea */
                if (!$servicioCombustibleEventLinea->getProduct()->getTieneNroSerie()) {
                    continue;
                }

                /** @var ServicioCombustible $servicioCombustible */
                $servicioCombustible = $servicioCombustibleEventLinea->getReferencedObject();
                if (null !== $servicioCombustible && $servicioCombustible instanceof ServicioCombustible) {
                    $marchamoSerial = $servicioCombustible->getMarchamo2();
                    call_user_func($fillBitacoraSerialEvents, $servicioCombustibleEventLinea, $marchamoSerial);
                }
            }
        }
    }
}
