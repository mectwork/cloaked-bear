<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Buseta\BusesBundle\Form\Model\VehiculoModel;

/**
 * Vehiculo.
 *
 * @ORM\Table(name="d_vehiculo")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\VehiculoRepository")
 */
class Vehiculo extends BaseVehiculo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @param VehiculoModel $model
     * @return Autobus
     */
    public function setModelData(VehiculoModel $model)
    {
        $this->matricula = $model->getMatricula();
        $this->numero = $model->getNumero();
        $this->numeroCilindros = $model->getNumeroCilindros();
        $this->numeroPlazas = $model->getNumeroPlazas();
        $this->cilindrada = $model->getCilindrada();
        $this->potencia = $model->getPotencia();
        $this->anno = $model->getAnno();
        $this->capacidadTanque = $model->getCapacidadTanque();
        $this->activo = $model->isActivo();
        $this->kilometraje = $model->getKilometraje();
        $this->marcaCajacambio = $model->getMarcaCajacambio();
        $this->tipoCajacambio = $model->getTipoCajacambio();
        $this->horas = $model->getHoras();

        if ($model->getMarca()) {
            $this->marca  = $model->getMarca();
        }
        if ($model->getMarcaMotor()) {
            $this->marcaMotor  = $model->getMarcaMotor();
        }
        if ($model->getModelo()) {
            $this->modelo  = $model->getModelo();
        }
        if ($model->getEstilo()) {
            $this->estilo  = $model->getEstilo();
        }
        if ($model->getColor()) {
            $this->color  = $model->getColor();
        }
        if ($model->getCombustible()) {
            $this->combustible  = $model->getCombustible();
        }

        return $this;
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
