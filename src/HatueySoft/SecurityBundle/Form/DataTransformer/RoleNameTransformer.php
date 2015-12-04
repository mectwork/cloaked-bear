<?php

namespace HatueySoft\SecurityBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class RoleNameTransformer
 */
class RoleNameTransformer implements DataTransformerInterface
{

    /**
     * If the passed argument is a valid role return the name, else return empty string
     * @param mixed $entity
     * @return integer|string
     */
    public function transform($entity)
    {
        if (is_null($entity) || strpos($entity, 'ROLE_') === false) {
            return '';
        }

        return substr($entity, strlen('ROLE_'), strlen($entity) - 1);
    }

    /**
     * Return the role with the correct structure
     *
     * @param string $name
     * @throws TransformationFailedException
     * @return object
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }

        return sprintf('ROLE_%s', $name);
    }
}
