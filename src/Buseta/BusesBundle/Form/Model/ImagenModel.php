<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImagenModel.
 */
class ImagenModel
{
    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenFrontal;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenFrontalInterior;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenLateralD;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenLateralI;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenTrasera;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenTraseraInterior;

    function __construct(Autobus $autobus)
    {
        if($autobus->getId() != null)
        {
            $this->id = $autobus->getId();
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontal()
    {
        return $this->imagenFrontal;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenFrontal
     */
    public function setImagenFrontal($imagenFrontal)
    {
        $this->imagenFrontal = $imagenFrontal;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralD()
    {
        return $this->imagenLateralD;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenLateralD
     */
    public function setImagenLateralD($imagenLateralD)
    {
        $this->imagenLateralD = $imagenLateralD;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralI()
    {
        return $this->imagenLateralI;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenLateralI
     */
    public function setImagenLateralI($imagenLateralI)
    {
        $this->imagenLateralI = $imagenLateralI;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenTrasera()
    {
        return $this->imagenTrasera;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenTrasera
     */
    public function setImagenTrasera($imagenTrasera)
    {
        $this->imagenTrasera = $imagenTrasera;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontalInterior()
    {
        return $this->imagenFrontalInterior;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenFrontalInterior
     */
    public function setImagenFrontalInterior($imagenFrontalInterior)
    {
        $this->imagenFrontalInterior = $imagenFrontalInterior;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getImagenTraseraInterior()
    {
        return $this->imagenTraseraInterior;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $imagenTraseraInterior
     */
    public function setImagenTraseraInterior($imagenTraseraInterior)
    {
        $this->imagenTraseraInterior = $imagenTraseraInterior;
    }

}
