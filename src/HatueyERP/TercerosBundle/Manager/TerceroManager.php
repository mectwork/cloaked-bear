<?php

namespace HatueyERP\TercerosBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

class TerceroManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }
} 