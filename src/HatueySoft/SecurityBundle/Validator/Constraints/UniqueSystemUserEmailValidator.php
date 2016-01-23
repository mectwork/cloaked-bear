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

    public function validate($data, Constraint $constraint)
    {
        $id = $data->getId();
        $email = $data->getEmail();

        if ($id === null && $this->userManager->findUserByEmail($email)) {
            $this->context->addViolationAt('email', $constraint->message, array('%email%' => $email));
        }
        if ($id !== null && ($user = $this->userManager->findUserByEmail($email)) && $user->getId() !== $id) {
            $this->context->addViolationAt('email', $constraint->message, array('%email%' => $email));
        }
    }
}
