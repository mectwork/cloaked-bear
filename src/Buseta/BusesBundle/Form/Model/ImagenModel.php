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
     * @var \Buseta\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenFrontal;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenFrontalInterior;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenLateralD;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenLateralI;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     * @Assert\Valid()
     */
    private $imagenTrasera;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
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
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontal()
    {
        return $this->imagenFrontal;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenFrontal
     */
    public function setImagenFrontal($imagenFrontal)
    {
        $this->imagenFrontal = $imagenFrontal;
    }

    /**
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralD()
    {
        return $this->imagenLateralD;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenLateralD
     */
    public function setImagenLateralD($imagenLateralD)
    {
        $this->imagenLateralD = $imagenLateralD;
    }

    /**
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralI()
    {
        return $this->imagenLateralI;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenLateralI
     */
    public function setImagenLateralI($imagenLateralI)
    {
        $this->imagenLateralI = $imagenLateralI;
    }

    /**
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenTrasera()
    {
        return $this->imagenTrasera;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenTrasera
     */
    public function setImagenTrasera($imagenTrasera)
    {
        $this->imagenTrasera = $imagenTrasera;
    }

    /**
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontalInterior()
    {
        return $this->imagenFrontalInterior;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenFrontalInterior
     */
    public function setImagenFrontalInterior($imagenFrontalInterior)
    {
        $this->imagenFrontalInterior = $imagenFrontalInterior;
    }

    /**
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenTraseraInterior()
    {
        return $this->imagenTraseraInterior;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenTraseraInterior
     */
    public function setImagenTraseraInterior($imagenTraseraInterior)
    {
        $this->imagenTraseraInterior = $imagenTraseraInterior;
    }

}
