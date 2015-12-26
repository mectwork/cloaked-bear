<?php

namespace Buseta\BusesBundle\Form\Model;


use Buseta\BusesBundle\Entity\ArchivoAdjunto;
use Symfony\Component\Validator\Constraints as Assert;

class ArchivoAdjuntoModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @var string
     */
    public $originalName;

    /**
     * @var string
     */
    public $extension;

    /**
     * @var string
     */
    public $path;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     *
     * @Assert\File(
     *     maxSize="6M",
     *     mimeTypes={"application/pdf",
     *          "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *          "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *          "application/zip", "application/x-compressed-zip",
     *          "application/x-rar-compressed"},
     *     mimeTypesMessage="El archivo seleccionado no es un archivo válido (pdf, doc, docx, xls, xlsx, zip, rar)."
     * )
     * @Assert\NotNull
     */
    private $file;


    /**
     * Construct
     */
    function __construct(ArchivoAdjunto $archivoAdjunto = null)
    {
        if ($archivoAdjunto !== null) {
            $this->id = $archivoAdjunto->getId();
            $this->path = $archivoAdjunto->getPath();
            $this->autobus = $archivoAdjunto->getAutobus();
            $this->originalName = $archivoAdjunto->getOriginalName();
            $this->extension    = $archivoAdjunto->getExtension();
        }
    }

    public function getEntityData()
    {
        $archivo = new ArchivoAdjunto();
        $archivo->setAutobus($this->getAutobus());
        $archivo->setFile($this->getFile());

        return $archivo;
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
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        // obtain rest of parameters on upload file
        $this->name = $file->getClientOriginalName();
        $this->extension = $file->getClientOriginalExtension();
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
}
