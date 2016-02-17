<?php
namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Persona;
use Buseta\BodegaBundle\Entity\Tercero;
use HatueySoft\SecurityBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\DataCollectorTranslator;

class TerceroManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var DataCollectorTranslator
     */
    private $trans;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * TerceroManager constructor.
     *
     * @param EntityManager           $em
     * @param Session                 $session
     * @param DataCollectorTranslator $trans
     * @param Logger                  $logger
     */
    function __construct(EntityManager $em, Session $session, DataCollectorTranslator $trans, Logger $logger)
    {
        $this->em       = $em;
        $this->session  = $session;
        $this->trans    = $trans;
        $this->logger   = $logger;
    }

    /**
     * @param User $user
     *
     * @return Tercero
     *
     * @throws \Exception
     */
    public function createPersonaFromSystemUser(User $user)
    {
        $tercero = new Tercero();
        $tercero->setNombres($user->getNombres());
        $tercero->setApellidos($user->getApellidos());
        $tercero->setAlias($user->getUsername());
        $tercero->setFoto($user->getFoto());
        $tercero->setUsuario($user);

        $persona = new Persona();
        $tercero->setPersona($persona);

        try {
            $this->em->persist($tercero);
            $this->em->flush();

            return $tercero;
        } catch (\Exception $e) {
            $error = $this->trans->trans('messages.create.error.%key%', array('key' => 'Tercero'), 'BusetaBodegaBundle');
            $this->logger->addCritical(sprintf('%s. %s', $error, $e->getMessage()));

            throw $e;
        }
    }
}
