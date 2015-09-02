<?php

namespace HatueySoft\SequenceBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sequence Model
 */
class SequenceFilterModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
