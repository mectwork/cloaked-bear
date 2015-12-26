<?php

namespace HatueySoft\SequenceBundle\Managers;


use Doctrine\Common\Persistence\ObjectManager;
use HatueySoft\SequenceBundle\Entity\Sequence;
use Symfony\Bridge\Monolog\Logger;

class SequenceManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var array
     */
    private $definedSequences;

    /**
     * @var Logger
     */
    private $logger;

    function __construct(ObjectManager $em, array $config, Logger $logger)
    {
        $this->em = $em;
        $this->definedSequences = $config['sequences'];
        $this->logger = $logger;
    }

    /**
     * Obtain default instance for sequence entity
     *
     * @return Sequence
     */
    public function getDefaultInstance()
    {
        $sequence = new Sequence();
        $sequence->setActive(false);
        $sequence->setType('incremental');
        $sequence->setNumberIncrement(1);
        $sequence->setNumberNextInterval(1);
        $sequence->setPadding(0);

        return $sequence;
    }

    /**
     * Determine if exist sequence for class and it's active
     *
     * @param $class
     * @return bool|mixed
     */
    public function hasSequence($class)
    {
        if (($index = array_search($class, $this->definedSequences)) && $index !== false) {
            return $this->em->getRepository('HatueySoftSequenceBundle:Sequence')
                ->isActive($index);
        }

        return false;
    }

    public function getNextValue($seqName)
    {
        $sequence = $this->em->getRepository('HatueySoftSequenceBundle:Sequence')
            ->findOneByName($seqName);

        if ($sequence === null && !array_key_exists($seqName, $this->definedSequences)) {
            throw new \Exception(sprintf('La sequencia con nombre "%s" no se encuentra definida.'));
        }

        if ($sequence === null) {
            $sequence = $this->getDefaultInstance();
            $sequence->setName($seqName);
        }

        $value = sprintf('%d', $sequence->getNumberNextInterval() + $sequence->getNumberIncrement());
        $padding = $sequence->getPadding();

        $length = strlen($value);
        if ($padding > $length) {
            $fill = '';
            for ($i = 0; $i < $padding - $length; $i++) {
                $fill.='0';
            }
            $value = sprintf('%s%s', $fill, $value);
        }

        $prefix = $sequence->getPrefix();
        if ($prefix !== null) {
            $value = sprintf('%s%s', $prefix, $value);
        }

        $suffix = $sequence->getSuffix();
        if ($suffix !== null) {
            $value = sprintf('%s%s', $value, $suffix);
        }

        // persistiendo los datos de la secuencia
        try {
            $sequence->setNumberNextInterval($sequence->getNumberNextInterval() + $sequence->getNumberIncrement());

            $this->em->persist($sequence);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->critical(sprintf('Ha ocurrido un error persistiendo los datos para la secuencia "%s. Detalles: %s', $sequence->getName(), $e->getMessage()));
        }

        return $value;
    }
}
