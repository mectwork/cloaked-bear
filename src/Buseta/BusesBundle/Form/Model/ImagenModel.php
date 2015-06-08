<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImagenModel.
 */
class ImagenModel
{
    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var UploadedFile
     */
    private $imagenFrontal;

    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var UploadedFile
     */
    private $imagenLateralD;

    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var UploadedFile
     */
    private $imagenLateralI;

    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var UploadedFile
     */
    private $imagenTrasera;

    function __construct(Autobus $autobus)
    {
        if($autobus->getId() != null)
        {
            $this->id = $autobus->getId();

            $this->imagenTrasera = $autobus->getImagenTrasera();
            $this->imagenFrontal = $autobus->getImagenFrontal();
            $this->imagenLateralD = $autobus->getImagenLateralD();
            $this->imagenLateralI = $autobus->getImagenLateralI();

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
     * @return UploadedFile
     */
    public function getImagenFrontal()
    {
        return $this->imagenFrontal;
    }

    /**
     * @param UploadedFile $imagenFrontal
     */
    public function setImagenFrontal($imagenFrontal)
    {
        $this->imagenFrontal = $imagenFrontal;
    }

    /**
     * @return UploadedFile
     */
    public function getImagenLateralD()
    {
        return $this->imagenLateralD;
    }

    /**
     * @param UploadedFile $imagenLateralD
     */
    public function setImagenLateralD($imagenLateralD)
    {
        $this->imagenLateralD = $imagenLateralD;
    }

    /**
     * @return UploadedFile
     */
    public function getImagenLateralI()
    {
        return $this->imagenLateralI;
    }

    /**
     * @param UploadedFile $imagenLateralI
     */
    public function setImagenLateralI($imagenLateralI)
    {
        $this->imagenLateralI = $imagenLateralI;
    }

    /**
     * @return UploadedFile
     */
    public function getImagenTrasera()
    {
        return $this->imagenTrasera;
    }

    /**
     * @param UploadedFile $imagenTrasera
     */
    public function setImagenTrasera($imagenTrasera)
    {
        $this->imagenTrasera = $imagenTrasera;
    }


}
