<?php

namespace HatueySoft\SecurityBundle\Validator\Constraints;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueSystemUserUsernameValidator extends ConstraintValidator
{
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if($this->userManager->findUserByUsername($value)) {
            $this->context->addViolation($constraint->message, array('%username%' => $value));
        }
    }
} 