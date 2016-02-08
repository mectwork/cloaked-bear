<?php

namespace Buseta\TallerBundle\Voter;

use HatueySoft\SecurityBundle\Voter\EntitiesActionsVoter;

/**
 * Class TallerEntitiesActionsVoter
 *
 * @package Buseta\TallerBundle\Voter
 */
class TallerEntitiesActionsVoter extends EntitiesActionsVoter
{
    const PROCESS = 'process';
    const COMPLETE = 'complete';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
            self::PROCESS,
            self::COMPLETE,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return gettype($class) === 'string';
    }
}
