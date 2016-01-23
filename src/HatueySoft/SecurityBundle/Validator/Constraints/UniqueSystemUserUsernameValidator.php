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

    public function validate($data, Constraint $constraint)
    {
        $id = $data->getId();
        $username = $data->getUsername();

        if ($id === null && $this->userManager->findUserByUsername($username)) {
            $this->context->addViolationAt('username', $constraint->message, array('%username%' => $username));
        }
        if ($id !== null && ($user = $this->userManager->findUserByUsername($username)) && $user->getId() !== $id) {
            $this->context->addViolationAt('username', $constraint->message, array('%username%' => $username));
        }
    }
}
