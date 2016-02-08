<?php

namespace HatueySoft\SecurityBundle\Utils;

use HatueySoft\SecurityBundle\Manager\AclRulesManager;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class VoterClassChecker
 *
 * @package HatueySoft\SecurityBundle\Utils
 */
class VoterClassChecker
{
    /**
     * @var AclRulesManager
     */
    private $aclRulesManager;


    /**
     * VoterClassChecker constructor.
     *
     * @param AclRulesManager $aclRulesManager
     */
    public function __construct(AclRulesManager $aclRulesManager)
    {
        $this->aclRulesManager = $aclRulesManager;
    }

    /**
     * @param string $class
     *
     * @return boolean
     */
    public function supportsClass($class)
    {
        $realClass = null;
        if (is_object($class)) {
            $realClass = ClassUtils::getRealClass($class);
        } elseif (is_string($class)) {
            $realClass = $class;
        }

        if ($realClass !== null && $this->aclRulesManager->getEntity($realClass)) {
            return true;
        }

        return false;
    }
}
