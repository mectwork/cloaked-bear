<?php

namespace Buseta\TallerBundle\Command;

use Buseta\BodegaBundle\Entity\CostoProducto;
use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BusesBundle\Entity\Autobus;
use Buseta\NomencladorBundle\Entity\Color;
use Buseta\TallerBundle\Entity\TareaMantenimiento;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTareasMantenimientoCommand extends ContainerAwareCommand
{
    private $grupos;
    private $subgrupos;
    private $tareas;
    private $garantias;

    /**
     * @var EntityManager $em
     */
    private $em;

    private $dry;

    protected function configure()
    {
        $this
            ->setName('taller:import:tareasmantenimiento')
            ->setDefinition(array(
                //new InputOption('ignore-ref','r', InputOption::VALUE_NONE, 'Ignora los errores relacionados con la Cédula para el Cliente e inserta en blanco el campo.'),
                new InputArgument('excel-ref', InputArgument::REQUIRED, 'Dirección de referencia para el archivo excel del cual cargar los datos.'),
                new InputOption('start-row','r', InputOption::VALUE_OPTIONAL, 'Fila en la cual empezar a procesar los datos.'),
                new InputOption('register-components','c', InputOption::VALUE_NONE, 'Registra las tareas, garantías, grupos y los subgrupos en el sistema.'),
                new InputOption('dry-run','d', InputOption::VALUE_NONE, 'Ejecuta el comando pero no registra los datos o actualiza entidades.'),
            ))
            ->setDescription('Importa los datos de las Tareas de Mantenimiento desde Excel.')
            ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputFormater = new OutputFormatter(true, array(
            'warn' => new OutputFormatterStyle('yellow')
        ));
        $output->setFormatter($outputFormater);

        $this->dry = $input->getOption('dry-run');

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

        $output->writeln("<info>Procesando datos para Tareas de Mantenimiento.</info>");

        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);

        $totalRows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $data = array(
            'A' => 'Tarea',
            'B' => 'Grupo',
            'C' => 'Subgrupo',
            'D' => 'Garantía',
            'E' => 'Kilómetros',
            'F' => 'Horas',
        );

        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->loadAll();
        if ($input->getOption('register-components')) {
            // registrando grupos
            $this->registerGrupos($objPHPExcel, $input, $output);
            // registrando subgrupos
            $this->registerSubgrupos($objPHPExcel, $input, $output);
        }

        /** @var ProgressHelper $progress */
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, $totalRows - $startRow);

        $sheet = $objPHPExcel->getActiveSheet();
        for ($i = $startRow; $i < $totalRows; $i++) {
            $rowData = array();
            foreach ($data as $key => $value) {
                $rowData[$key] = $sheet->getCell($key . ($i + 1))->getValue();
            }

            $this->createTareaMantenimiento($rowData, $output, $progress);

            $progress->advance();
        }

        $progress->finish();
        $output->writeln("<info>Terminado procesado para Tareas de Mantenimiento.</info>");
    }

    private function createTareaMantenimiento($data, OutputInterface $output, ProgressHelper $progress)
    {
        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        $newtareamantenimiento = new TareaMantenimiento();
        $newtareamantenimiento->setValor($this->selectTarea($data['A'], $output, $dialog, $progress));
        $newtareamantenimiento->setGrupo($this->selectGrupo($data['B'], $output, $dialog, $progress));
        $newtareamantenimiento->setSubgrupo($this->selectSubgrupo($data['C'], $output, $dialog, $progress));
        $newtareamantenimiento->setGarantia($this->selectGarantia($data['D'], $output, $dialog, $progress));
        $newtareamantenimiento->setKilometros($data['E']);
        $newtareamantenimiento->setHoras($data['F']);

        $validator = $this->getContainer()->get('validator');
        $errors = $validator->validate($newtareamantenimiento);

        if ($errors->count() === 0) {
            try {
                if (!$this->dry) {
                    $this->em->persist($newtareamantenimiento);
                    $this->em->flush();
                }

                return $newtareamantenimiento;
            } catch (\Exception $e) {
                $progress->clear();
                $output->writeln(sprintf('<error>Ha ocurrido un error persistiendo los datos de la nueva Tarea Mantenimiento. Detalles %s</error>', $e->getMessage()), OutputInterface::OUTPUT_NORMAL);
                $progress->display();

                return null;
            }
        } else {
            $progress->clear();
            $output->writeln('<error>La Tarea de Mantenimiento contiene parámetros con errores de validación. No se crea la entidad.</error>');
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
            if (strtolower($grupo) == strtolower($g->getValor()) || substr_count(strtolower($grupo), strtolower($g->getValor()))  > 0) {
                $g->setValor($grupo);
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
                $grupo = $this->addNomenclador(array(
                    'valor' => $grupo
                ), 'Buseta\NomencladorBundle\Entity\Grupo');
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
            if (strtolower($subgrupo) == strtolower($c->getValor()) || substr_count(strtolower($subgrupo), strtolower($c->getValor()))  > 0) {
                $c->setValor($subgrupo);
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

    private function selectGarantia($garantia, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->garantias as $g) {
            if (strtolower($garantia) == strtolower($g->getValor())) {
                $garantia = $g;
                break;
            } else {
                $choices[$count++] = $g->getValor();
            }
        }

        if (!is_object($garantia)) {
            $choices[$count] = 'Crearlo nuevo';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una Garantía que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o la última opción para crearlo nuevo.', $garantia),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $garantia = $this->addNomenclador($garantia, 'Buseta\NomencladorBundle\Entity\UOM');
            } else {
                $garantia = $this->garantias[$result];
            }
        }

        return $garantia;
    }

    private function selectTarea($tarea, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
    {
        $choices = array();
        $count = 0;
        foreach ($this->tareas as $p) {
            if (strtolower($tarea) == strtolower($p->getValor())) {
                $tarea = $p;
                break;
            } else {
                $choices[$count++] = $p->getValor();
            }
        }

        if (!is_object($tarea)) {
            $choices[$count] = 'Salir dejar vacío (NULL)';

            $progress->clear();
            $result = $dialog->select(
                $output,
                sprintf('No se encontró una Tarea que se corresponda con <info>"%s"</info>. Seleccione del listado el que se corresponda o intente creándolo desde la interfaz del sistema.', $tarea),
                $choices,
                $count,
                false,
                'El valor %s no es correcto.'
            );
            $progress->display();

            if ($result == $count) {
                $tarea = $this->addNomenclador($tarea, 'Buseta\NomencladorBundle\Entity\UOM');
            } else {
                $tarea = $this->tareas[$result];
            }
        }

        return $tarea;
    }

    private function reloadTareas()
    {
        $this->tareas = $this->em->getRepository('BusetaNomencladorBundle:Tarea')->findAll();
    }

    private function reloadGrupo()
    {
        $this->grupos = $this->em->getRepository('BusetaNomencladorBundle:Grupo')->findAll();
    }

    private function reloadSubgrupo()
    {
        $this->subgrupos = $this->em->getRepository('BusetaNomencladorBundle:Subgrupo')->findAll();
    }

    private function reloadGarantias()
    {
        $this->garantias = $this->em->getRepository('BusetaNomencladorBundle:GarantiaTarea')->findAll();
    }

    private function loadAll()
    {
        $this->reloadTareas();
        $this->reloadGrupo();
        $this->reloadSubgrupo();
        $this->reloadGarantias();
    }

    private function addNomenclador($nomenclador, $class)
    {
        $entity = new $class();
        foreach ($nomenclador as $key => $value) {
            $setMethod = sprintf('set%s', ucfirst($key));
            $entity->$setMethod($value);
        }

        if (!$this->dry) {
            $this->em->persist($entity);
            $this->em->flush();
        }

        // 'Buseta\NomencladorBundle\Entity\*'
        $reloadMethod = sprintf('reload%s', explode('\\', $class)[3]);
        $this->$reloadMethod();

        return $entity;
    }

    private function registerGrupos(\PHPExcel $objPHPExcel, InputInterface $input, OutputInterface $output)
    {
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        $grupos = array();
        for ($i = 2; $i < $highestRow + 1; $i++) {
            $grupo = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getValue();
            if (!in_array($grupo, $grupos)) {
                $grupos[] = $grupo;
            }
        }

        $count = count($grupos);
        /** @var ProgressHelper $progress */
        $output->writeln('<info>Comenzando procesado de Grupos.</info>');
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, $count);

        foreach ($grupos as $value) {
            $object = null;
            $subvalue = substr($value, 0, 32);
            foreach ($this->grupos as $grupo) {
                if (strtolower($value) == strtolower($grupo->getValor())) {
                    $object = $grupo;
                    break;
                } else if (strtolower($subvalue) == strtolower($grupo->getValor())) {
                    $progress->clear();
                    $output->writeln(sprintf('<info>El grupo con nombre "%s" se encuentra registrado como "%s", se procede a actualizar sus datos.</info>', $value, $subvalue));
                    $progress->display();

                    $grupo->setValor($value);
                    $object = $grupo;
                    if (!$this->dry) {
                        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($grupo);
                        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
                    }
                    break;
                }
            }

            if(!$object) {
                $progress->clear();
                $output->writeln(sprintf('<warn>No se ha encontrado un grupo con nombre "%s", se procede a crearlo en los nomencladores.</warn>', $value));
                $progress->display();

                $this->addNomenclador(array(
                    'valor' => $value,
                ), 'Buseta\NomencladorBundle\Entity\Grupo');

                $this->reloadGrupo();


            }

            $progress->advance();
        }

        $progress->finish();
    }

    private function registerSubgrupos(\PHPExcel $objPHPExcel, InputInterface $input, OutputInterface $output)
    {
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        $subgrupos  = array();
        $subaux     = array();
        for ($i = 2; $i < $highestRow + 1; $i++) {
            $grupo = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getValue();
            $subgrupo = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getValue();
            if (!in_array($subgrupo, $subaux)) {
                $subgrupos[] = array(
                    'valor' => trim($subgrupo),
                    'grupo' => $grupo
                );
                $subaux[] = $subgrupo;
            }
        }

        $count = count($subgrupos);
        /** @var ProgressHelper $progress */
        $output->writeln('<info>Comenzando procesado de Subgrupos.</info>');
        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, $count);

        foreach ($subgrupos as $value) {
            $object = null;
            $subvalue = substr($value['valor'], 0, 32);
            var_dump($value['valor'], $subvalue);
            foreach ($this->subgrupos as $subgrupo) {
                if (strtolower($value['grupo']) == strtolower($subgrupo->getGrupo()->getValor()) && strtolower($value['valor']) == strtolower($subgrupo->getValor())) {
                    $object = $subgrupo;
                    break;
                } else if (strtolower($value['grupo']) == strtolower($subgrupo->getGrupo()->getValor()) && strtolower($subvalue) == strtolower($subgrupo->getValor())) {
                    $progress->clear();
                    $output->writeln(sprintf('<info>El subgrupo con nombre "%s" se encuentra registrado como "%s", se procede a actualizar sus datos.</info>', $value['valor'], $subvalue));
                    $progress->display();

                    $subgrupo->setValor($value['valor']);
                    $object = $subgrupo;
                    if (!$this->dry) {
                        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($subgrupo);
                        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
                    }
                    break;
                }
            }

            if(!$object) {
                $progress->clear();
                $output->writeln(sprintf('<warn>No se ha encontrado un subgrupo con nombre "%s", se procede a crearlo en los nomencladores.</warn>', $value['valor']));
                $progress->display();

                $grupo = null;
                foreach ($this->grupos as $g) {
                    if (strtolower($value['grupo']) == strtolower($g->getValor())) {
                        $grupo = $g;
                        break;
                    }
                }
                $this->addNomenclador(array(
                    'valor' => $value['valor'],
                    'grupo' => $grupo,
                ), 'Buseta\NomencladorBundle\Entity\Subgrupo');

                $this->reloadSubgrupo();
            }

            $progress->advance();
        }

        $progress->finish();
    }

//    private function selectingComponent($startObject, $object, $result, $count, $type, OutputInterface $output,  DialogHelper $dialog, ProgressHelper $progress)
//    {
//        $typeSelected = sprintf('%sSelected', $type);
//        $typeLinked   = sprintf('%sLinked', $type);
//
//        if (in_array($startObject, $this->$typeSelected)) {
//            $progress->clear();
//            $confirm = $dialog->askConfirmation(
//                $output,
//                sprintf('<info>Ha seleccionado un Proveedor para el nombre "%s" por segunda vez.</info> <question>¿Desea asignar de forma automática el Proveedor seleccionado en sus próximas apariciones y no preguntarle?</question>', $startObject),
//                true
//            );
//            $progress->display();
//        } else {
//            $this->$typeSelected[] = $startObject;
//        }
//
//        if ($result == $count) {
//            if (isset($confirm) && $confirm) {
//                $this->$typeLinked[$startObject] = 'null';
//            }
//
//            return null;
//        } else {
//            if (isset($confirm) && $confirm) {
//                $this->$typeLinked[$startObject] = $result;
//            }
//
//            $object = $this->$type[$result];
//        }
//
//        if (isset($confirm) && $confirm) {
//            unset($this->$typeSelected[array_search($startObject, $this->$typeSelected)]);
//        }
//
//        return $object;
//    }
}
