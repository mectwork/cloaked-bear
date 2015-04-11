<?php

namespace Buseta\BusesBundle\Command;

use Buseta\BusesBundle\Entity\Autobus;
use Buseta\NomencladorBundle\Entity\Color;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBusesCommand extends ContainerAwareCommand
{
    private $colores;
    private $combustibles;
    private $estilos;
    private $marcas;
    private $modelos;
    private $marcasmotor;

    /**
     * @var EntityManager $em
     */
    private $em;

    protected function configure()
    {
        $this
            ->setName('taller:import:buses')
            ->setDefinition(array(
                //new InputOption('ignore-ref','r', InputOption::VALUE_NONE, 'Ignora los errores relacionados con la Cédula para el Cliente e inserta en blanco el campo.'),
                new InputArgument('excel-ref', InputArgument::REQUIRED, 'Dirección de referencia para el archivo excel del cual cargar los datos.'),
                new InputOption('start-row','r', InputOption::VALUE_OPTIONAL, 'Fila en la cual empezar a procesar los datos.'),
            ))
            ->setDescription('Importa los datos de los Buses desde Excel.')
            ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('excel-ref');
        $verbose = $input->getOption('verbose');
        $startRow = 3;
        if($input->getOption('start-row')) {
            $startRow = $input->getOption('start-row');
        }

        if (!file_exists($file)) {
            $output->writeln(sprintf('<error>No se encuentra el archivo "%s" en la dirección especificada.</error>', $file));
            return;
        }

        $output->writeln("<info>Procesando datos de los Buses.</info>");

        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);

        $totalRows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $data = array(
            'A' => 'Nº BUS',
            'B' => 'Matricula',
            'C' => 'Número chasis',
            'D' => 'Número motor',
            'E' => 'Peso tara',
            'F' => 'Peso bruto',
            'G' => 'Número plazas',
            'H' => 'Número cilindros',
            'I' => 'Cilindrada',
            'J' => 'Potencia',
            'K' => 'Fecha ingreso',
            'L' => 'Válido hasta',
            'M' => 'Estilo',
            'N' => 'Fecha RTV 1',
            'O' => 'Fecha RTV 2',
            'P' => 'Combustible',
            'Q' => 'Marca',
            'R' => 'Modelo',
            'S' => 'Color',
            'T' => 'Marca motor',
            'U' => 'Capacidad (litros)',
            'V' => 'Tiene rampa',
            'W' => 'Tiene barras',
            'X' => 'Tiene lector de cédulas ',
            'Y' => 'Tiene publicidad',
            'Z' => 'Tiene GPS',
            'AA' => 'Tiene Wifi',
            'AB' => 'AÑO',
        );

        /** @var ProgressHelper $progress */
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, $totalRows - $startRow);

        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->loadAll();
        $sheet = $objPHPExcel->getActiveSheet();
        for ($i = $startRow; $i < $totalRows; $i++) {
            $rowData = array();
            foreach ($data as $key => $value) {
                $rowData[$key] = $sheet->getCell($key . ($i + 1))->getFormattedValue();
            }

            $this->createBus($rowData, $output, $progress);

            $progress->advance();
        }

        $progress->finish();
        $output->writeln("<info>Terminado procesado de Buses.</info>");
    }

    private function createBus($data, OutputInterface $output, ProgressHelper $progress)
    {
        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        $newbus = new Autobus();
        $newbus->setNumero($data['A']);
        $newbus->setMatricula($data['B']);
        $newbus->setNumeroChasis($data['C']);
        $newbus->setNumeroMotor($data['D']);
        $newbus->setPesoTara((int)$data['E']);
        $newbus->setPesoBruto((int)$data['F']);
        $newbus->setNumeroPlazas((int)$data['G']);
        $newbus->setNumeroCilindros((int)$data['H']);
        $newbus->setCilindrada((int)$data['I']);
        $newbus->setPotencia((int)$data['J']);
        $newbus->setFechaIngreso(date_create_from_format('d/m/Y', $data['K']));
        $newbus->setValidoHasta(date_create_from_format('d/m/Y', $data['L']));

        // Seleccionando Estilo
        $newbus->setEstilo($this->selectEstilo($data['M'], $output, $dialog, $progress));

        $newbus->setFechaRtv1($data['N']);
        $newbus->setFechaRtv2($data['O']);

        // Seleccionando Combustible
        $newbus->setCombustible($this->selectCombustible($data['P'], $output, $dialog, $progress));
        // Seleccionando Marca
        $newbus->setMarca($this->selectMarca($data['Q'], $output, $dialog, $progress));
        // Seleccionando Modelo
        $newbus->setModelo($this->selectModelo($data['R'], $output, $dialog, $progress));
        // Seleccionando Color
        $newbus->setColor($this->selectColor($data['S'], $output, $dialog, $progress));
        // Seleccionando Marca Motor
        $newbus->setMarcaMotor($this->selectMarcaMotor($data['T'], $output, $dialog, $progress));

        $newbus->setCapacidadTanque((int)$data['U']);
        $newbus->setRampas($data['V'] !== 'No' ? 'Tiene rampa' : null);
        $newbus->setBarras($data['W'] !== 'No' ? 'Tiene barra' : null);
        $newbus->setLectorCedulas($data['X'] !== 'No' ? 'Tiene lector' : null);
        $newbus->setPublicidad($data['Y'] !== 'No' ? 'Tiene publicidad' : null);
        $newbus->setGps($data['Z'] !== 'No' ? 'Tiene gps' : null);
        $newbus->setWifi($data['AA'] !== 'No' ? 'Tiene wifi' : null);
        $newbus->setAnno((int)$data['AB']);

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($newbus, array('console'));

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newbus);
                $this->em->flush();

                return $newbus;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos del nuevo Autobus. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>El Autobus contiene parámetros que contienen errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();
            return null;
        }
    }

    private function selectEstilo($estilo, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->estilos as $e) {
            if (strtolower($estilo) == strtolower($e->getValor())) {
                $estilo = $e;
                break;
            } else {
                $choices[$count++] = $e->getValor();
            }
        }

        if (!is_object($estilo)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Estilo que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $estilo),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $estilo = $this->addNomenclador($estilo, 'Buseta\NomencladorBundle\Entity\Estilo');
            } else {
                $estilo = $this->estilos[$result];
            }
        }

        return $estilo;
    }

    private function selectCombustible($combustible, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->combustibles as $c) {
            if (strtolower($combustible) == strtolower($c->getValor())) {
                $combustible = $c;
                break;
            } else {
                $choices[$count++] = $c->getValor();
            }
        }

        if (!is_object($combustible)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Combustible que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $combustible),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $combustible = $this->addNomenclador($combustible, 'Buseta\NomencladorBundle\Entity\Combustible');
            } else {
                $combustible = $this->combustibles[$result];
            }
        }

        return $combustible;
    }

    private function selectMarca($marca, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->marcas as $m) {
            if (strtolower($marca) == strtolower($m->getValor())) {
                $marca = $m;
                break;
            } else {
                $choices[$count++] = $m->getValor();
            }
        }

        if (!is_object($marca)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una Marca que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $marca),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $marca = $this->addNomenclador($marca, 'Buseta\NomencladorBundle\Entity\Marca');
            } else {
                $marca = $this->marcas[$result];
            }
        }

        return $marca;
    }

    private function selectModelo($modelo, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->modelos as $m) {
            if (strtolower($modelo) == strtolower($m->getValor())) {
                $modelo = $m;
                break;
            } else {
                $choices[$count++] = $m->getValor();
            }
        }

        if (!is_object($modelo)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Modelo que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $modelo),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $modelo = $this->addNomenclador($modelo, 'Buseta\NomencladorBundle\Entity\Modelo');
            } else {
                $modelo = $this->modelos[$result];
            }
        }

        return $modelo;
    }

    private function selectColor($color, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->colores as $c) {
            if (strtolower($color) == strtolower($c->getValor())) {
                $color = $c;
                break;
            } else {
                $choices[$count++] = $c->getValor();
            }
        }

        if (!is_object($color)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Color que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $color),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $color = $this->addNomenclador($color, 'Buseta\NomencladorBundle\Entity\Color');
            } else {
                $color = $this->colores[$result];
            }
        }

        return $color;
    }

    private function selectMarcaMotor($marcaMotor, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->marcasmotor as $m) {
            if (strtolower($marcaMotor) == strtolower($m->getValor())) {
                $marcaMotor = $m;
                break;
            } else {
                $choices[$count++] = $m->getValor();
            }
        }

        if (!is_object($marcaMotor)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una Marca Motor que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $marcaMotor),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $marcaMotor = $this->addNomenclador($marcaMotor, 'Buseta\NomencladorBundle\Entity\MarcaMotor');
            } else {
                $marcaMotor = $this->marcasmotor[$result];
            }
        }

        return $marcaMotor;
    }

    private function reloadColor()
    {
        $this->colores = $this->em->getRepository('BusetaNomencladorBundle:Color')->findAll();
    }

    private function reloadEstilo()
    {
        $this->estilos = $this->em->getRepository('BusetaNomencladorBundle:Estilo')->findAll();
    }

    private function reloadCombustible()
    {
        $this->combustibles = $this->em->getRepository('BusetaNomencladorBundle:Combustible')->findAll();
    }

    private function reloadMarca()
    {
        $this->marcas = $this->em->getRepository('BusetaNomencladorBundle:Marca')->findAll();
    }

    private function reloadModelo()
    {
        $this->modelos = $this->em->getRepository('BusetaNomencladorBundle:Modelo')->findAll();
    }

    private function reloadMarcaMotor()
    {
        $this->marcasmotor = $this->em->getRepository('BusetaNomencladorBundle:MarcaMotor')->findAll();
    }

    private function loadAll()
    {
        $this->reloadColor();
        $this->reloadCombustible();
        $this->reloadEstilo();
        $this->reloadMarca();
        $this->reloadModelo();
        $this->reloadMarcaMotor();
    }

    private function addNomenclador($value, $class)
    {
        $entity = new $class();
        $entity->setValor($value);

        $this->em->persist($entity);
        $this->em->flush();

        // 'Buseta\NomencladorBundle\Entity\*'
        $reloadMethod = sprintf('reload%s', explode('\\', $class)[3]);
        $this->$reloadMethod();

        return $entity;
    }
}
