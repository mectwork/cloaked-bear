<?php

namespace HatueySoft\MenuBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MenuNodeAttribute
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    function __construct($key = null, $value = null)
    {
        if ($key !== null) {
            $this->key = $key;
            $this->value = $value;
        }
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
