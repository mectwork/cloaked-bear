<?php

namespace Buseta\BodegaBundle\Command;

use Buseta\BodegaBundle\Entity\Direccion;
use Buseta\BodegaBundle\Entity\MecanismoContacto;
use Buseta\BodegaBundle\Entity\Proveedor;
use Buseta\BodegaBundle\Entity\Tercero;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProveedoresCommand extends ContainerAwareCommand
{
    private $monedas;

    /**
     * @var EntityManager $em
     */
    private $em;

    protected function configure()
    {
        $this
            ->setName('taller:import:proveedores')
            ->setDefinition(array(
                new InputArgument('excel-ref', InputArgument::REQUIRED, 'Dirección de referencia para el archivo excel del cual cargar los datos.'),
                new InputOption('start-row','r', InputOption::VALUE_OPTIONAL, 'Fila en la cual empezar a procesar los datos.'),
            ))
            ->setDescription('Importa los datos de los Proveedores desde Excel.')
            ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('excel-ref');
        $verbose = $input->getOption('verbose');
        $startRow = 2;
        if($input->getOption('start-row')) {
            $startRow = $input->getOption('start-row');
        }

        if (!file_exists($file)) {
            $output->writeln(sprintf('<error>No se encuentra el archivo "%s" en la dirección especificada.</error>', $file));
            return;
        }

        $output->writeln("<info>Procesando datos de los Proveedores.</info>");

        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);

        $totalRows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $data = array(
            'A' => 'Codigo',
            'B' => 'Alias',
            'C' => 'Nombres',
            'D' => 'CIFNIF',
            'E' => 'Calle',
            'F' => 'Localidad',
            'G' => 'Region',
            'H' => 'Telefono',
            'I' => 'Fax',
            'J' => 'Moneda',
            'K' => 'Forma de Pago',
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

            $this->createProveedor($rowData, $output, $progress);

            $progress->advance();
        }

        $progress->finish();
        $output->writeln("<info>Terminado procesado de Proveedores.</info>");
    }

    private function createProveedor($data, OutputInterface $output, ProgressHelper $progress)
    {
        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        $validator = $this->getContainer()->get('validator');

        //Crear Tercero
        $newTercero = new Tercero();
        $newTercero->setCodigo($data['A']);
        $newTercero->setAlias($data['B']);
        $newTercero->setNombres($data['C']);
        //$newTercero->setCIFNIF($data['D']);
        $newTercero->setActivo(true);

        $errors = $validator->validate($newTercero, array('console'));

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newTercero);
                $this->em->flush();

                return $newTercero;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos del nuevo Tercero. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>El Tercero contiene parámetros que contienen errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();
            return null;
        }

        //Crear Direccion
        $newDireccion = new Direccion();
        $newDireccion->setTercero($newTercero);
        $newDireccion->setCalle($data['E']);
        $newDireccion->setLocalidad($data['F']);
        $newDireccion->setRegion($data['G']);
        $newDireccion->setPais('CR');

        $errors = $validator->validate($newDireccion, array('console'));

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newDireccion);
                $this->em->flush();

                return $newDireccion;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos de la nueva Direccion. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>La Direccion contiene parámetros que contienen errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();
            return null;
        }

        //Crear MecanismoContacto
        $newMecanismoContacto = new MecanismoContacto();
        $newMecanismoContacto->setTelefono($data['H']);
        $newMecanismoContacto->setFax($data['I']);

        $errors = $validator->validate($newMecanismoContacto, array('console'));

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newMecanismoContacto);
                $this->em->flush();

                return $newMecanismoContacto;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos de la nueva MecanismoContacto. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>La MecanismoContacto contiene parámetros que contienen errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();
            return null;
        }

        //Asignar atributo 'direccion' a Tercero
        $newTercero->addDireccione($newDireccion);
        $newTercero->addMecanismosContacto($newMecanismoContacto);
        $this->em->persist($newTercero);
        $this->em->flush();

        //Crear MecanismoContacto
        $newMecanismoContacto = new MecanismoContacto();

        //Crear el Proveedor
        $newProveedor = new Proveedor();

        // Seleccionando Moneda
        $newProveedor->setMoneda($this->selectMoneda($data['J'], $output, $dialog, $progress));
        $newProveedor->setTercero($newTercero);

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newTercero);
                $this->em->flush();

                return $newTercero;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos del nuevo Tercero. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>El Tercero contiene parámetros que contienen errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();
            return null;
        }

    }

    private function selectMoneda($moneda, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->monedas as $e) {
            if (strtolower($moneda) == strtolower($e->getValor())) {
                $estilo = $e;
                break;
            } else {
                $choices[$count++] = $e->getValor();
            }
        }

        if (!is_object($moneda)) {
            $choices[$count] = 'Crearla nueva';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una Moneda que se corresponda con "%s". Seleccione del listado el que se corresponda o la última opción para crearla nueva.', $moneda),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $moneda = $this->addNomenclador($moneda, 'Buseta\NomencladorBundle\Entity\Moneda');
            } else {
                $moneda = $this->monedas[$result];
            }
        }

        return $moneda;
    }

    private function reloadMoneda()
    {
        $this->monedas = $this->em->getRepository('BusetaNomencladorBundle:Moneda')->findAll();
    }

    private function loadAll()
    {
        $this->reloadMoneda();
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
