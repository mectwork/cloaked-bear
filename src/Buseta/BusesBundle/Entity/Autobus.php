<?php

namespace Buseta\BusesBundle\Entity;

use Buseta\BusesBundle\Form\Model\FiltroModel;
use Buseta\BusesBundle\Form\Model\ImagenModel;
use Buseta\BusesBundle\Form\Model\InformacionExtraModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Buseta\BusesBundle\Form\Model\AutobusBasicoModel;

/**
 * Autobus.
 *
 * @ORM\Table(name="d_autobus")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\AutobusRepository")
 * @UniqueEntity(fields={"matricula"})
 */
class Autobus
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
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenFrontal;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenFrontalInterior;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenLateralD;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenLateralI;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenTrasera;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $imagenTraseraInterior;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BusesBundle\Entity\ArchivoAdjunto", mappedBy="autobus", cascade={"persist","remove"})
     * @Assert\File(groups={"web", "Autobus"})
     * @Assert\Valid()
     */
    private $archivosAdjuntos;

    /**
     * @var string
     *
     * @ORM\Column(name="matricula", type="string", length=32)
     * @Assert\NotBlank(groups={"web", "console", "Autobus"})
     */
    private $matricula;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=32)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="marcaCajacambio", type="string", nullable=true)
     */
    private $marcaCajacambio;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoCajacambio", type="string", nullable=true)
     */
    private $tipoCajacambio;

    /**
     * @var string
     *
     * @ORM\Column(name="bateria1", type="string", nullable=true)
     */
    private $bateria1;

    /**
     * @var string
     *
     * @ORM\Column(name="bateria2", type="string", nullable=true)
     */
    private $bateria2;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroChasis", type="string", length=32)
     */
    private $numeroChasis;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroMotor", type="string", length=32)
     */
    private $numeroMotor;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroAceite", mappedBy="autobus", cascade={"all"})
     */
    private $filtroAceite;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroAgua", mappedBy="autobus", cascade={"all"})
     */
    private $filtroAgua;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroDiesel", mappedBy="autobus", cascade={"all"})
     */
    private $filtroDiesel;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroHidraulico", mappedBy="autobus", cascade={"all"})
     */
    private $filtroHidraulico;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroTransmision", mappedBy="autobus", cascade={"all"})
     */
    private $filtroTransmision;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroCaja", mappedBy="autobus", cascade={"all"})
     */
    private $filtroCaja;

    /**
     * @var string
     *
     * @ORM\Column(name="carterCapacidadlitros", type="string", nullable=true)
     */
    private $carterCapacidadlitros;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Marca")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteCajaCambios")
     */
    private $aceitecajacambios;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteHidraulico")
     */
    private $aceitehidraulico;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteMotor")
     */
    private $aceitemotor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteTransmision")
     */
    private $aceitetransmision;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Modelo")
     */
    private $modelo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Estilo")
     */
    private $estilo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\Compra", mappedBy="centro_costo", cascade={"all"})
     */
    private $compras;

    /**
     * @var integer
     *
     * @ORM\Column(name="pesoTara", type="integer")
     * @Assert\Type(type="integer", groups={"web", "console", "Autobus"})
     */
    private $pesoTara;

    /**
     * @var integer
     *
     * @ORM\Column(name="pesoBruto", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $pesoBruto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Color")
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroPlazas", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $numeroPlazas;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\MarcaMotor")
     */
    private $marcaMotor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Combustible")
     */
    private $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="anno", type="integer", nullable=true)
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $anno;

    /**
     * @var integer
     *
     * @ORM\Column(name="valorUnidad", type="integer", nullable=true)
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $valorUnidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidadTanque", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $capacidadTanque;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroUnidad", type="integer", nullable=true)
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $numeroUnidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroCilindros", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $numeroCilindros;

    /**
     * @var integer
     *
     * @ORM\Column(name="cilindrada", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $cilindrada;

    /**
     * @var integer
     *
     * @ORM\Column(name="potencia", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    private $potencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validoHasta", type="date")
     * @Assert\Date(groups={"web", "console", "Autobus"})
     */
    private $validoHasta;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaRtv1", type="string")
     */
    private $fechaRtv1;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaRtv2", type="string")
     */
    private $fechaRtv2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaIngreso", type="date")
     * @Assert\Date(groups={"web", "console", "Autobus"})
     */
    private $fechaIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="rampas", type="string", nullable=true)
     */
    private $rampas;

    /**
     * @var string
     *
     * @ORM\Column(name="barras", type="string", nullable=true)
     */
    private $barras;

    /**
     * @var string
     *
     * @ORM\Column(name="camaras", type="string", nullable=true)
     */
    private $camaras;

    /**
     * @var string
     *
     * @ORM\Column(name="lectorCedulas", type="string", nullable=true)
     */
    private $lectorCedulas;

    /**
     * @var string
     *
     * @ORM\Column(name="publicidad", type="string", nullable=true)
     */
    private $publicidad;

    /**
     * @var string
     *
     * @ORM\Column(name="gps", type="string", nullable=true)
     */
    private $gps;

    /**
     * @var string
     *
     * @ORM\Column(name="wifi", type="string", nullable=true)
     */
    private $wifi;

    /**
     * @var integer
     *
     * @ORM\Column(name="kilometraje", type="integer")
     */
    private $kilometraje;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="horas", type="integer")
     */
    private $horas;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->archivosAdjuntos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->kilometraje = 0;
        $this->horas = 0;
    }

    /**
     * Set model para datos básicos
     *
     * @param AutobusBasicoModel $model
     * @return Autobus
     */
    public function setModelData(AutobusBasicoModel $model)
    {
        $this->matricula = $model->getMatricula();
        $this->numero = $model->getNumero();
        $this->numeroChasis = $model->getNumeroChasis();
        $this->numeroCilindros = $model->getNumeroCilindros();
        $this->numeroMotor = $model->getNumeroMotor();
        $this->numeroPlazas = $model->getNumeroPlazas();
        $this->pesoTara = $model->getPesoTara();
        $this->pesoBruto = $model->getPesoBruto();
        $this->cilindrada = $model->getCilindrada();
        $this->potencia = $model->getPotencia();
        $this->validoHasta = $model->getValidoHasta();
        $this->fechaIngreso = $model->getFechaIngreso();
        $this->fechaRtv1 = $model->getFechaRtv1();
        $this->fechaRtv2 = $model->getFechaRtv2();
        $this->capacidadTanque = $model->getCapacidadTanque();
        $this->rampas = $model->getRampas();
        $this->barras = $model->getBarras();
        $this->wifi = $model->getWifi();
        $this->gps = $model->getGps();
        $this->camaras = $model->getCamaras();
        $this->lectorCedulas = $model->getLectorCedulas();
        $this->publicidad = $model->getPublicidad();
        $this->activo = $model->getActivo();
        $this->kilometraje = $model->getKilometraje();
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
        if (!$model->getArchivosAdjuntos()->isEmpty()) {
            foreach ($model->getArchivosAdjuntos() as $archivo) {
                $newArchivo = $archivo->getEntityData();
                $this->addArchivosAdjunto($newArchivo);
            }
        }

        return $this;
    }

    /**
     * Set model para Información Extra
     *
     * @param InformacionExtraModel $model
     * @return Autobus
     */
    public function setModelDataInformacionExtra(InformacionExtraModel $model)
    {
        $this->numeroUnidad = $model->getNumeroUnidad();
        $this->valorUnidad = $model->getValorUnidad();
        $this->anno = $model->getAnno();
        $this->marcaCajacambio = $model->getMarcaCajacambio();
        $this->tipoCajacambio = $model->getTipoCajacambio();
        $this->carterCapacidadlitros = $model->getCarterCapacidadlitros();
        $this->bateria1 = $model->getBateria1();
        $this->bateria2 = $model->getBateria2();

        if ($model->getAceitecajacambios()) {
            $this->aceitecajacambios  = $model->getAceitecajacambios();
        }

        if ($model->getAceitetransmision()) {
            $this->aceitetransmision  = $model->getAceitetransmision();
        }

        if ($model->getAceitemotor()) {
            $this->aceitemotor  = $model->getAceitemotor();
        }

        if ($model->getAceitehidraulico()) {
            $this->aceitehidraulico  = $model->getAceitehidraulico();
        }


        return $this;
    }

    /**
     * Set model para Filtros
     *
     * @param FiltroModel $model
     * @return Autobus
     */
    public function setModelDataFiltro(FiltroModel $model)
    {

        if($model->getFiltroCaja()->hasData()){
            $this->setFiltroCaja($model->getFiltroCaja());
        }

        if($model->getFiltroDiesel()->hasData()){
            $this->setFiltroDiesel($model->getFiltroDiesel());
        }

        if($model->getFiltroAceite()->hasData()){
            $this->setFiltroAceite($model->getFiltroAceite());
        }

        if($model->getFiltroTransmision()->hasData()){
            $this->setFiltroTransmision($model->getFiltroTransmision());
        }

        if($model->getFiltroAgua()->hasData()){
            $this->setFiltroAgua($model->getFiltroAgua());
        }

        if($model->getFiltroHidraulico()->hasData()){
            $this->setFiltroHidraulico($model->getFiltroHidraulico());
        }

        return $this;
    }

    /**
     * Set model para Imágenes
     *
     * @param ImagenModel $model
     * @return Autobus
     */
    public function setModelDataImagen(ImagenModel $model)
    {
        if($model->getImagenFrontal() != null) {
            $this->imagenFrontal = $model->getImagenFrontal();
        }

        if($model->getImagenFrontalInterior() != null) {
            $this->imagenFrontalInterior = $model->getImagenFrontalInterior();
        }

        if($model->getImagenTrasera() != null) {
            $this->imagenTrasera = $model->getImagenTrasera();
        }

        if($model->getImagenTraseraInterior() != null) {
            $this->imagenTraseraInterior = $model->getImagenTraseraInterior();
        }

        if($model->getImagenLateralD() != null) {
            $this->imagenLateralD = $model->getImagenLateralD();
        }

        if($model->getImagenLateralI() != null) {
            $this->imagenLateralI = $model->getImagenLateralI();
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

    /**
     * Set imagenFrontal
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenFrontal
     * @return Autobus
     */
    public function setImagenFrontal($imagenFrontal)
    {
        $this->imagenFrontal = $imagenFrontal;

        return $this;
    }

    /**
     * Get imagenFrontal
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontal()
    {
        return $this->imagenFrontal;
    }

    /**
     * Set imagenLateralD
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenLateralD
     * @return Autobus
     */
    public function setImagenLateralD($imagenLateralD)
    {
        $this->imagenLateralD = $imagenLateralD;

        return $this;
    }

    /**
     * Get imagenLateralD
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralD()
    {
        return $this->imagenLateralD;
    }

    /**
     * Set imagenLateralI
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenLateralI
     * @return Autobus
     */
    public function setImagenLateralI($imagenLateralI)
    {
        $this->imagenLateralI = $imagenLateralI;

        return $this;
    }

    /**
     * Get imagenLateralI
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenLateralI()
    {
        return $this->imagenLateralI;
    }

    /**
     * Set imagenTrasera
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenTrasera
     * @return Autobus
     */
    public function setImagenTrasera($imagenTrasera)
    {
        $this->imagenTrasera = $imagenTrasera;

        return $this;
    }

    /**
     * Get imagenTrasera
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenTrasera()
    {
        return $this->imagenTrasera;
    }

    /**
     * Set imagenTraseraInterior
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenTraseraInterior
     * @return Autobus
     */
    public function setImagenTraseraInterior($imagenTraseraInterior)
    {
        $this->imagenTraseraInterior = $imagenTraseraInterior;

        return $this;
    }

    /**
     * Get imagenTraseraInterior
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenTraseraInterior()
    {
        return $this->imagenTraseraInterior;
    }

    /**
     * Set imagenFrontalInterior
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $imagenFrontalInterior
     * @return Autobus
     */
    public function setImagenFrontalInterior($imagenFrontalInterior)
    {
        $this->imagenFrontalInterior = $imagenFrontalInterior;

        return $this;
    }

    /**
     * Get imagenFrontalInterior
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getImagenFrontalInterior()
    {
        return $this->imagenFrontalInterior;
    }

    /**
     * Set matricula.
     *
     * @param string $matricula
     *
     * @return Autobus
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula.
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Set marcaCajacambio.
     *
     * @param string $marcaCajacambio
     *
     * @return Autobus
     */
    public function setMarcaCajacambio($marcaCajacambio)
    {
        $this->marcaCajacambio = $marcaCajacambio;

        return $this;
    }

    /**
     * Get marcaCajacambio.
     *
     * @return string
     */
    public function getMarcaCajacambio()
    {
        return $this->marcaCajacambio;
    }

    /**
     * Set tipoCajacambio.
     *
     * @param string $tipoCajacambio
     *
     * @return Autobus
     */
    public function setTipoCajacambio($tipoCajacambio)
    {
        $this->tipoCajacambio = $tipoCajacambio;

        return $this;
    }

    /**
     * Get tipoCajacambio.
     *
     * @return string
     */
    public function getTipoCajacambio()
    {
        return $this->tipoCajacambio;
    }

    /**
     * Set bateria1.
     *
     * @param string $bateria1
     *
     * @return Autobus
     */
    public function setBateria1($bateria1)
    {
        $this->bateria1 = $bateria1;

        return $this;
    }

    /**
     * Get bateria1.
     *
     * @return string
     */
    public function getBateria1()
    {
        return $this->bateria1;
    }

    /**
     * Set bateria2.
     *
     * @param string $bateria2
     *
     * @return Autobus
     */
    public function setBateria2($bateria2)
    {
        $this->bateria2 = $bateria2;

        return $this;
    }

    /**
     * Get bateria2.
     *
     * @return string
     */
    public function getBateria2()
    {
        return $this->bateria2;
    }

    /**
     * Set numeroChasis.
     *
     * @param string $numeroChasis
     *
     * @return Autobus
     */
    public function setNumeroChasis($numeroChasis)
    {
        $this->numeroChasis = $numeroChasis;

        return $this;
    }

    /**
     * Get numeroChasis.
     *
     * @return string
     */
    public function getNumeroChasis()
    {
        return $this->numeroChasis;
    }

    /**
     * Set numeroMotor.
     *
     * @param string $numeroMotor
     *
     * @return Autobus
     */
    public function setNumeroMotor($numeroMotor)
    {
        $this->numeroMotor = $numeroMotor;

        return $this;
    }

    /**
     * Get numeroMotor.
     *
     * @return string
     */
    public function getNumeroMotor()
    {
        return $this->numeroMotor;
    }

    /**
     * Set carterCapacidadlitros.
     *
     * @param string $carterCapacidadlitros
     *
     * @return Autobus
     */
    public function setCarterCapacidadlitros($carterCapacidadlitros)
    {
        $this->carterCapacidadlitros = $carterCapacidadlitros;

        return $this;
    }

    /**
     * Get carterCapacidadlitros.
     *
     * @return string
     */
    public function getCarterCapacidadlitros()
    {
        return $this->carterCapacidadlitros;
    }

    /**
     * Set pesoTara.
     *
     * @param integer $pesoTara
     *
     * @return Autobus
     */
    public function setPesoTara($pesoTara)
    {
        $this->pesoTara = $pesoTara;

        return $this;
    }

    /**
     * Get pesoTara.
     *
     * @return integer
     */
    public function getPesoTara()
    {
        return $this->pesoTara;
    }

    /**
     * Set pesoBruto.
     *
     * @param integer $pesoBruto
     *
     * @return Autobus
     */
    public function setPesoBruto($pesoBruto)
    {
        $this->pesoBruto = $pesoBruto;

        return $this;
    }

    /**
     * Get pesoBruto.
     *
     * @return integer
     */
    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    /**
     * Set numeroPlazas.
     *
     * @param integer $numeroPlazas
     *
     * @return Autobus
     */
    public function setNumeroPlazas($numeroPlazas)
    {
        $this->numeroPlazas = $numeroPlazas;

        return $this;
    }

    /**
     * Get numeroPlazas.
     *
     * @return integer
     */
    public function getNumeroPlazas()
    {
        return $this->numeroPlazas;
    }

    /**
     * Set anno.
     *
     * @param integer $anno
     *
     * @return Autobus
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno.
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set valorUnidad.
     *
     * @param integer $valorUnidad
     *
     * @return Autobus
     */
    public function setValorUnidad($valorUnidad)
    {
        $this->valorUnidad = $valorUnidad;

        return $this;
    }

    /**
     * Get valorUnidad.
     *
     * @return integer
     */
    public function getValorUnidad()
    {
        return $this->valorUnidad;
    }

    /**
     * Set capacidadTanque.
     *
     * @param integer $capacidadTanque
     *
     * @return Autobus
     */
    public function setCapacidadTanque($capacidadTanque)
    {
        $this->capacidadTanque = $capacidadTanque;

        return $this;
    }

    /**
     * Get capacidadTanque.
     *
     * @return integer
     */
    public function getCapacidadTanque()
    {
        return $this->capacidadTanque;
    }

    /**
     * Set numeroUnidad.
     *
     * @param integer $numeroUnidad
     *
     * @return Autobus
     */
    public function setNumeroUnidad($numeroUnidad)
    {
        $this->numeroUnidad = $numeroUnidad;

        return $this;
    }

    /**
     * Get numeroUnidad.
     *
     * @return integer
     */
    public function getNumeroUnidad()
    {
        return $this->numeroUnidad;
    }

    /**
     * Set numeroCilindros.
     *
     * @param integer $numeroCilindros
     *
     * @return Autobus
     */
    public function setNumeroCilindros($numeroCilindros)
    {
        $this->numeroCilindros = $numeroCilindros;

        return $this;
    }

    /**
     * Get numeroCilindros.
     *
     * @return integer
     */
    public function getNumeroCilindros()
    {
        return $this->numeroCilindros;
    }

    /**
     * Set cilindrada.
     *
     * @param integer $cilindrada
     *
     * @return Autobus
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    /**
     * Get cilindrada.
     *
     * @return integer
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set potencia.
     *
     * @param integer $potencia
     *
     * @return Autobus
     */
    public function setPotencia($potencia)
    {
        $this->potencia = $potencia;

        return $this;
    }

    /**
     * Get potencia.
     *
     * @return integer
     */
    public function getPotencia()
    {
        return $this->potencia;
    }

    /**
     * Set validoHasta.
     *
     * @param \DateTime $validoHasta
     *
     * @return Autobus
     */
    public function setValidoHasta($validoHasta)
    {
        $this->validoHasta = $validoHasta;

        return $this;
    }

    /**
     * Get validoHasta.
     *
     * @return \DateTime
     */
    public function getValidoHasta()
    {
        return $this->validoHasta;
    }

    /**
     * Set fechaRtv1.
     *
     * @param string $fechaRtv1
     *
     * @return Autobus
     */
    public function setFechaRtv1($fechaRtv1)
    {
        $this->fechaRtv1 = $fechaRtv1;

        return $this;
    }

    /**
     * Get fechaRtv1.
     *
     * @return string
     */
    public function getFechaRtv1()
    {
        return $this->fechaRtv1;
    }

    /**
     * Set fechaRtv2.
     *
     * @param string $fechaRtv2
     *
     * @return Autobus
     */
    public function setFechaRtv2($fechaRtv2)
    {
        $this->fechaRtv2 = $fechaRtv2;

        return $this;
    }

    /**
     * Get fechaRtv2.
     *
     * @return string
     */
    public function getFechaRtv2()
    {
        return $this->fechaRtv2;
    }

    /**
     * Set fechaIngreso.
     *
     * @param \DateTime $fechaIngreso
     *
     * @return Autobus
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso.
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set rampas.
     *
     * @param string $rampas
     *
     * @return Autobus
     */
    public function setRampas($rampas)
    {
        $this->rampas = $rampas;

        return $this;
    }

    /**
     * Get rampas.
     *
     * @return string
     */
    public function getRampas()
    {
        return $this->rampas;
    }

    /**
     * Set barras.
     *
     * @param string $barras
     *
     * @return Autobus
     */
    public function setBarras($barras)
    {
        $this->barras = $barras;

        return $this;
    }

    /**
     * Get barras.
     *
     * @return string
     */
    public function getBarras()
    {
        return $this->barras;
    }

    /**
     * Set camaras.
     *
     * @param string $camaras
     *
     * @return Autobus
     */
    public function setCamaras($camaras)
    {
        $this->camaras = $camaras;

        return $this;
    }

    /**
     * Get camaras.
     *
     * @return string
     */
    public function getCamaras()
    {
        return $this->camaras;
    }

    /**
     * Set lectorCedulas.
     *
     * @param string $lectorCedulas
     *
     * @return Autobus
     */
    public function setLectorCedulas($lectorCedulas)
    {
        $this->lectorCedulas = $lectorCedulas;

        return $this;
    }

    /**
     * Get lectorCedulas.
     *
     * @return string
     */
    public function getLectorCedulas()
    {
        return $this->lectorCedulas;
    }

    /**
     * Set publicidad.
     *
     * @param string $publicidad
     *
     * @return Autobus
     */
    public function setPublicidad($publicidad)
    {
        $this->publicidad = $publicidad;

        return $this;
    }

    /**
     * Get publicidad.
     *
     * @return string
     */
    public function getPublicidad()
    {
        return $this->publicidad;
    }

    /**
     * Set gps.
     *
     * @param string $gps
     *
     * @return Autobus
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get gps.
     *
     * @return string
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Set wifi.
     *
     * @param string $wifi
     *
     * @return Autobus
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;

        return $this;
    }

    /**
     * Get wifi.
     *
     * @return string
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * Set filtroAceite.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroAceite $filtroAceite
     *
     * @return Autobus
     */
    public function setFiltroAceite(\Buseta\BusesBundle\Entity\FiltroAceite $filtroAceite = null)
    {
        $filtroAceite->setAutobus($this);
        $this->filtroAceite = $filtroAceite;

        return $this;
    }

    /**
     * Get filtroAceite.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroAceite
     */
    public function getFiltroAceite()
    {
        return $this->filtroAceite;
    }

    /**
     * Set filtroAgua.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroAgua $filtroAgua
     *
     * @return Autobus
     */
    public function setFiltroAgua(\Buseta\BusesBundle\Entity\FiltroAgua $filtroAgua = null)
    {
        $filtroAgua->setAutobus($this);
        $this->filtroAgua = $filtroAgua;

        return $this;
    }

    /**
     * Get filtroAgua.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroAgua
     */
    public function getFiltroAgua()
    {
        return $this->filtroAgua;
    }

    /**
     * Set filtroDiesel.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroDiesel $filtroDiesel
     *
     * @return Autobus
     */
    public function setFiltroDiesel(\Buseta\BusesBundle\Entity\FiltroDiesel $filtroDiesel = null)
    {
        $filtroDiesel->setAutobus($this);
        $this->filtroDiesel = $filtroDiesel;

        return $this;
    }

    /**
     * Get filtroDiesel.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroDiesel
     */
    public function getFiltroDiesel()
    {
        return $this->filtroDiesel;
    }

    /**
     * Set filtroHidraulico.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroHidraulico $filtroHidraulico
     *
     * @return Autobus
     */
    public function setFiltroHidraulico(\Buseta\BusesBundle\Entity\FiltroHidraulico $filtroHidraulico = null)
    {
        $filtroHidraulico->setAutobus($this);
        $this->filtroHidraulico = $filtroHidraulico;

        return $this;
    }

    /**
     * Get filtroHidraulico.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroHidraulico
     */
    public function getFiltroHidraulico()
    {
        return $this->filtroHidraulico;
    }

    /**
     * Set filtroTransmision.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroTransmision $filtroTransmision
     *
     * @return Autobus
     */
    public function setFiltroTransmision(\Buseta\BusesBundle\Entity\FiltroTransmision $filtroTransmision = null)
    {
        $filtroTransmision->setAutobus($this);
        $this->filtroTransmision = $filtroTransmision;

        return $this;
    }

    /**
     * Get filtroTransmision.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroTransmision
     */
    public function getFiltroTransmision()
    {
        return $this->filtroTransmision;
    }

    /**
     * Set filtroCaja.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroCaja $filtroCaja
     *
     * @return Autobus
     */
    public function setFiltroCaja(\Buseta\BusesBundle\Entity\FiltroCaja $filtroCaja = null)
    {
        $filtroCaja->setAutobus($this);
        $this->filtroCaja = $filtroCaja;

        return $this;
    }

    /**
     * Get filtroCaja.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroCaja
     */
    public function getFiltroCaja()
    {
        return $this->filtroCaja;
    }

    /**
     * @return mixed
     */
    public function getAceitecajacambios()
    {
        return $this->aceitecajacambios;
    }

    /**
     * @param mixed $aceitecajacambios
     */
    public function setAceitecajacambios($aceitecajacambios)
    {
        $this->aceitecajacambios = $aceitecajacambios;
    }

    /**
     * @return mixed
     */
    public function getAceitehidraulico()
    {
        return $this->aceitehidraulico;
    }

    /**
     * @param mixed $aceitehidraulico
     */
    public function setAceitehidraulico($aceitehidraulico)
    {
        $this->aceitehidraulico = $aceitehidraulico;
    }

    /**
     * @param mixed $archivoAdjunto
     */
    public function setArchivoAdjunto($archivoAdjunto)
    {
        $this->archivoAdjunto = $archivoAdjunto;
    }

    /**
     * Add compras.
     *
     * @param \Buseta\TallerBundle\Entity\Compra $compras
     *
     * @return Autobus
     */
    public function addCompra(\Buseta\TallerBundle\Entity\Compra $compras)
    {
        $compras->setCentroCosto($this);

        $this->compras[] = $compras;

        return $this;
    }

    /**
     * Remove compras.
     *
     * @param \Buseta\TallerBundle\Entity\Compra $compras
     */
    public function removeCompra(\Buseta\TallerBundle\Entity\Compra $compras)
    {
        $this->compras->removeElement($compras);
    }

    /**
     * Get compras.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * @return mixed
     */
    public function getAceitemotor()
    {
        return $this->aceitemotor;
    }

    /**
     * @param mixed $aceitemotor
     */
    public function setAceitemotor($aceitemotor)
    {
        $this->aceitemotor = $aceitemotor;
    }

    /**
     * @return mixed
     */
    public function getAceitetransmision()
    {
        return $this->aceitetransmision;
    }

    /**
     * @param mixed $aceitetransmision
     */
    public function setAceitetransmision($aceitetransmision)
    {
        $this->aceitetransmision = $aceitetransmision;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param mixed $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return mixed
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     * @param mixed $estilo
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getMarcaMotor()
    {
        return $this->marcaMotor;
    }

    /**
     * @param mixed $marcaMotor
     */
    public function setMarcaMotor($marcaMotor)
    {
        $this->marcaMotor = $marcaMotor;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Set kilometraje.
     *
     * @param integer $kilometraje
     *
     * @return Autobus
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;

        return $this;
    }

    /**
     * Get kilometraje.
     *
     * @return integer
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Set horas.
     *
     * @param integer $horas
     *
     * @return Autobus
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas.
     *
     * @return integer
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Add archivosAdjuntos
     *
     * @param \Buseta\BusesBundle\Entity\ArchivoAdjunto $archivosAdjuntos
     * @return Autobus
     */
    public function addArchivosAdjunto(\Buseta\BusesBundle\Entity\ArchivoAdjunto $archivosAdjuntos)
    {
        $archivosAdjuntos->setAutobus($this);

        $this->archivosAdjuntos[] = $archivosAdjuntos;

        return $this;
    }

    /**
     * Remove archivosAdjuntos
     *
     * @param \Buseta\BusesBundle\Entity\ArchivoAdjunto $archivosAdjuntos
     */
    public function removeArchivosAdjunto(\Buseta\BusesBundle\Entity\ArchivoAdjunto $archivosAdjuntos)
    {
        $archivosAdjuntos->setAutobus(null);

        $this->archivosAdjuntos->removeElement($archivosAdjuntos);
    }

    /**
     * Get archivosAdjuntos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivosAdjuntos()
    {
        return $this->archivosAdjuntos;
    }

    public function __toString()
    {
        return sprintf('%d (%s)', $this->numero, $this->matricula);
    }
}
