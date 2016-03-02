<?php

namespace Buseta\CombustibleBundle\Event\BitacoraBodega;


use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Event\BitacoraBodega\AbstractBitacoraEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\CombustibleBundle\Entity\ConfiguracionCombustible;
use Buseta\CombustibleBundle\Entity\ConfiguracionMarchamo;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Symfony\Component\Security\Core\Util\ClassUtils;

class BitacoraServicioCombustibleEvent extends AbstractBitacoraEvent
{
    /**
     * @var ServicioCombustible
     */
    private $servicioCombustible;


    /**
     * BitacoraServicioCombustibleEvent constructor.
     *
     * @param ConfiguracionCombustible $configuracionCombustible
     * @param ConfiguracionMarchamo    $configuracionMarchamo
     * @param ServicioCombustible|null $servicioCombustible
     */
    public function __construct(
        ServicioCombustible $servicioCombustible,
        ConfiguracionCombustible $configuracionCombustible,
        ConfiguracionMarchamo $configuracionMarchamo
    ) {
        parent::__construct();

        if ($servicioCombustible !== null) {
            $this->servicioCombustible = $servicioCombustible;

            $combustibleEvent = new BitacoraEventModel();
            $combustibleEvent->setProduct($configuracionCombustible->getProducto());
            $combustibleEvent->setWarehouse($configuracionCombustible->getBodega());
            $combustibleEvent->setMovementQty($servicioCombustible->getCantidadLibros());
            $combustibleEvent->setMovementDate(new \DateTime());
            $combustibleEvent->setMovementType(BusetaBodegaMovementTypes::INTERNAL_CONSUMPTION_MINUS);
            $combustibleEvent->setReferencedObject($servicioCombustible);
            $combustibleEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($servicioCombustible) {
                $bitacoraAlmacen->setConsumoInterno(
                    sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($servicioCombustible),
                        $servicioCombustible->getId()
                    )
                );
            });
            $this->bitacoraEvents->add($combustibleEvent);

            $marchamoEvent = new BitacoraEventModel();
            $marchamoEvent->setProduct($configuracionMarchamo->getProducto());
            $marchamoEvent->setWarehouse($configuracionMarchamo->getBodega());
            $marchamoEvent->setMovementQty(1);
            $marchamoEvent->setMovementDate(new \DateTime());
            $marchamoEvent->setMovementType(BusetaBodegaMovementTypes::INTERNAL_CONSUMPTION_MINUS);
            $marchamoEvent->setReferencedObject(array(
                'servicioCombustible' => $servicioCombustible,
                'marchamo' => $configuracionMarchamo->getProducto(),
            ));
            $marchamoEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($servicioCombustible) {
                $bitacoraAlmacen->setConsumoInterno(
                    sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($servicioCombustible),
                        $servicioCombustible->getId()
                    )
                );
            });
            $this->bitacoraEvents->add($marchamoEvent);
        }
    }
}
