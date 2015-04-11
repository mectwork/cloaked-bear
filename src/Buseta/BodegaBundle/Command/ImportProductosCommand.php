<?php

namespace Buseta\BodegaBundle\Command;

use Buseta\BodegaBundle\Entity\CostoProducto;
use Buseta\BodegaBundle\Entity\Producto;
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

class ImportProductosCommand extends ContainerAwareCommand
{
    private $grupos;
    private $subgrupos;
    private $uomesures;
    private $proveedores;
    private $proveedoresSelected;
    private $proveedoresLinked;

    /**
     * @var EntityManager $em
     */
    private $em;

    protected function configure()
    {
        $this
            ->setName('taller:import:productos')
            ->setDefinition(array(
                //new InputOption('ignore-ref','r', InputOption::VALUE_NONE, 'Ignora los errores relacionados con la Cédula para el Cliente e inserta en blanco el campo.'),
                new InputArgument('excel-ref', InputArgument::REQUIRED, 'Dirección de referencia para el archivo excel del cual cargar los datos.'),
                new InputOption('start-row','r', InputOption::VALUE_OPTIONAL, 'Fila en la cual empezar a procesar los datos.'),
            ))
            ->setDescription('Importa los datos de los Productos desde Excel.')
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

        $output->writeln("<info>Procesando datos de los Productos.</info>");

        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);

        $totalRows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $data = array(
            'A' => 'Grupo',
            'B' => 'Subgrupo',
            'C' => 'CÓDIGO ATSA',
            'D' => 'CÓDIGO A',
            'E' => 'DESCRIPCION',
            'F' => 'U.MEDIDA',
            'H' => 'COSTO',
            'I' => 'PROVEEDOR',
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

            $this->createProducto($rowData, $output, $progress);

            $progress->advance();
        }

        $progress->finish();
        $output->writeln("<info>Terminado procesado de Productos.</info>");
    }

    private function createProducto($data, OutputInterface $output, ProgressHelper $progress)
    {
        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        $newproducto = new Producto();
        $newproducto->setCodigo($data['C']);
        $newproducto->setCodigoA($data['D']);
        $newproducto->setNombre($data['E']);
        $newproducto->setDescripcion($data['E']);
        $newproducto->setActivo(true);

        // Seleccionando UOM
        $newproducto->setUOM($this->selectUOM($data['F'], $output, $dialog, $progress));
        // Seleccionando Grupo
        $newproducto->setGrupo($this->selectGrupo($data['A'], $output, $dialog, $progress));
        // Seleccionando Subgrupo
        $newproducto->setSubgrupo($this->selectSubgrupo($data['B'], $output, $dialog, $progress));
        // Seleccionando Proveedor
        $newproducto->setProveedor($this->selectProveedor($data['I'], $output, $dialog, $progress));

        // Adicionando Costo
        $costo = new CostoProducto();
        $costo->setActivo(true);
        $costo->setCosto((float)$data['H']);
        $newproducto->addCostoProducto($costo);

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($newproducto);

        if ($errors->count() === 0) {
            try {
                $this->em->persist($newproducto);
                $this->em->flush();

                return $newproducto;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos del nuevo Producto. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>El Producto contiene parámetros con errores de validación. No se crea la entidad.</error>');
            foreach ($errors as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                $output->writeln(sprintf('<error>%s: %s</error>', $error->getPropertyPath(), $error->getMessage()));
            }
            $progress->display();

            return null;
        }
    }

    private function selectGrupo($grupo, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->grupos as $g) {
            if (strtolower($grupo) == strtolower($g->getValor())) {
                $grupo = $g;
                break;
            } else {
                $choices[$count++] = $g->getValor();
            }
        }

        if (!is_object($grupo)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Grupo que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $grupo),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $grupo = $this->addNomenclador($grupo, 'Buseta\NomencladorBundle\Entity\Grupo');
            } else {
                $grupo = $this->grupos[$result];
            }
        }

        return $grupo;
    }

    private function selectSubgrupo($subgrupo, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->subgrupos as $c) {
            if (strtolower($subgrupo) == strtolower($c->getValor())) {
                $subgrupo = $c;
                break;
            } else {
                $choices[$count++] = $c->getValor();
            }
        }

        if (!is_object($subgrupo)) {
            $choices[$count] = 'Salir y dejar vacío (Null)';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Subgrupo que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o intente creándolo desde la interfaz del sistema.', $subgrupo),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                return null;
            } else {
                $subgrupo = $this->subgrupos[$result];
            }
        }

        return $subgrupo;
    }

    private function selectUOM($uom, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->uomesures as $m) {
            if (strtolower($uom) == strtolower($m->getValor())) {
                $uom = $m;
                break;
            } else {
                $choices[$count++] = $m->getValor();
            }
        }

        if (!is_object($uom)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una UOM que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $uom),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $uom = $this->addNomenclador($uom, 'Buseta\NomencladorBundle\Entity\UOM');
            } else {
                $uom = $this->uomesures[$result];
            }
        }

        return $uom;
    }

    private function selectProveedor($proveedor, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        if (isset($this->proveedoresLinked[$proveedor])) {
            return $this->proveedoresLinked[$proveedor] === 'null' ? null : $this->proveedores[$this->proveedoresLinked[$proveedor]];
        }

        $choices = array();
        $count = 0;
        $startProveedor = $proveedor;
        foreach ($this->proveedores as $m) {
            if (strtolower($proveedor) == strtolower($m->getValor())) {
                $proveedor = $m;
                break;
            } else {
                $choices[$count++] = $m->getValor();
            }
        }

        if (!is_object($proveedor)) {
            $choices[$count] = 'Salir dejar vacío (NULL)';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró un Proveedor que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o intente creándolo desde la interfaz del sistema.', $proveedor),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if (in_array($startProveedor, $this->proveedoresSelected)) {
                $progress->clear();
                $confirm = $dialog->askConfirmation(
                    $output,
                    sprintf('<info>Ha seleccionado un Proveedor para el nombre "%s" por segunda vez.</info> <question>¿Desea asignar de forma automática el Proveedor seleccionado en sus próximas apariciones y no preguntarle?</question>', $startProveedor),
                    true
                );
                $progress->display();
            } else {
                $this->proveedoresSelected[] = $startProveedor;
            }

            if ($result == $count) {
                if (isset($confirm) && $confirm) {
                    $this->proveedoresLinked[$startProveedor] = 'null';
                }

                return null;
            } else {
                if (isset($confirm) && $confirm) {
                    $this->proveedoresLinked[$startProveedor] = $result;
                }

                $proveedor = $this->proveedores[$result];
            }

            if (isset($confirm) && $confirm) {
                unset($this->proveedoresSelected[array_search($startProveedor, $this->proveedoresSelected)]);
            }
        }

        return $proveedor;
    }

    private function reloadProvedor()
    {
        $qb = $this->em->getRepository('BusetaBodegaBundle:Tercero')->createQueryBuilder('t');
        $this->proveedores = $qb->leftJoin('t.proveedor', 'p')
            ->where($qb->expr()->isNotNull('p'));
    }

    private function reloadGrupo()
    {
        $this->grupos = $this->em->getRepository('BusetaNomencladorBundle:Grupo')->findAll();
    }

    private function reloadSubgrupo()
    {
        $this->subgrupos = $this->em->getRepository('BusetaNomencladorBundle:Subgrupo')->findAll();
    }

    private function reloadUOM()
    {
        $this->uomesures = $this->em->getRepository('BusetaNomencladorBundle:UOM')->findAll();
    }

    private function loadAll()
    {
        $this->reloadProvedor();
        $this->reloadGrupo();
        $this->reloadSubgrupo();
        $this->reloadUOM();
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
