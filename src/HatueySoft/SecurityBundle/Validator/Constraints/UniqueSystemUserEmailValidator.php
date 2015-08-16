<?php

namespace HatueySoft\SecurityBundle\Validator\Constraints;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueSystemUserEmailValidator extends ConstraintValidator
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
        if($this->userManager->findUserByEmail($value)) {
            $this->context->addViolation($constraint->message, array('%email%' => $value));
        }
    }
} 