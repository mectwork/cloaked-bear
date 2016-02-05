<?php

namespace HatueySoft\SecurityBundle\Voter;

use HatueySoft\SecurityBundle\Utils\AclRulesManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultEntityActionsVoter implements VoterInterface
{
    const PROCESS = 'process';
    const COMPLETE = 'complete';

    /**
     * @var \HatueySoft\SecurityBundle\Utils\AclRulesManager
     */
    private $rulesManager;


    function __construct(AclRulesManager $rulesManager)
    {
        $this->rulesManager = $rulesManager;
    }

    /**
     * Checks if the voter supports the given attribute.
     *
     * @param string $attribute An attribute
     *
     * @return bool    true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
            self::PROCESS,
            self::COMPLETE,
        ));
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return bool    true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        return gettype($class) === 'string';
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param string $object The object to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int     either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass($object)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed for this voter'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $user = $token->getUser();

        // make sure there is a user object(i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        // check first for role permission if fails check user permission
        $roles = $user->getRoles();
        if ($this->rulesManager->checkEntityRolePermission($object, $roles, $attribute)) {
            return VoterInterface::ACCESS_GRANTED;
        }

        if ($this->rulesManager->checkEntityUserPermission($object, $user->getUsername(), $attribute)) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }

}
