<?php

namespace HatueySoft\SecurityBundle\Utils;

/**
 * Class VoterAttributesChecker
 *
 * @package HatueySoft\SecurityBundle\Utils
 */
class VoterAttributesChecker
{
    const CREATE = 'create';
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const LISTS = 'list';
    const SEARCH = 'search';

    /**
     * @param string $attribute
     *
     * @return boolean
     */
    public function supportsAttribute($attribute)
    {
        return in_array(strtolower($attribute), array(
            self::CREATE,
            self::VIEW,
            self::EDIT,
            self::DELETE,
            self::LISTS,
            self::SEARCH
        ));
    }
}
