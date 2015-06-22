<?php

namespace Buseta\BusesBundle\Entity;

use Buseta\UploadBundle\Model\UploadAbstract;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArchivoAdjunto.
 *
 * @ORM\Table(name="d_autobus_archivo_adjunto")
 * @ORM\Entity
 */
class ArchivoAdjunto extends UploadAbstract
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="archivosAdjuntos")
     */
    private $autobus;

    /**
     * {@inheritDoc}
     *
     * @Assert\File(
     *     maxSize="6M",
     *     mimeTypes={"application/pdf",
     *          "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.documen",
     *          "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *          "application/zip", "application/x-compressed-zip",
     *          "application/x-rar-compressed"},
     *     mimeTypesMessage="El archivo seleccionado no es un archivo válido (pdf, doc, docx, xls, xlsx, zip, rar)."
     * )
     * @Assert\NotNull()
     */
    protected $file;

    /**
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
