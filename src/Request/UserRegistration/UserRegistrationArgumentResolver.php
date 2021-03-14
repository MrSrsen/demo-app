<?php

namespace App\Request\UserRegistration;

use App\Repository\RoleRepository;
use App\Request\DataObjectArgumentResolverInterface;
use App\Service\ArgumentResolverValidationException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationArgumentResolver implements ArgumentValueResolverInterface, DataObjectArgumentResolverInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private RoleRepository $roleRepository,
    ) {}

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === UserRegistrationRequest::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $registrationRequest = new UserRegistrationRequest(
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('email'),
            $request->get('password'),
            $request->get('passwordVerify'),
            $request->get('roleId'),
        );

        $result = $this->validator->validate($registrationRequest);

        if ($result->count() > 0) {
            $exception = new ArgumentResolverValidationException("Registration validations failed!");
            $exception->populateErrorsWithViolationsList($result);
            throw $exception;
        }

        if (!$registrationRequest->hasSamePasswords()) {
            $exception = new ArgumentResolverValidationException('Passwords do not match!');
            $exception->setErrors([
                'passwordVerify' => 'Passwords are not the same!'
            ]);
            throw $exception;
        }

        try {
            $this->roleRepository->findOneById($registrationRequest->getRoleId());
            yield $registrationRequest;
        } catch (EntityNotFoundException) {
            $exception = new ArgumentResolverValidationException('Entity was not found!');
            $exception->setErrors([
                'roleId' => 'Role do not exists!'
            ]);
            throw $exception;
        }
    }
}
