<?php

namespace App\Controller;

use App\Request\UserRegistration\UserRegistrationRequest;
use App\Service\UserRegistrationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class RegistrationController
{
    public function __construct(
        private UserRegistrationService $userRegistrationService,
        private ValidatorInterface $validator,
    ) {}

    #[Route('/users', name: 'register_user', methods: ['POST'])]
    public function register(UserRegistrationRequest $registrationRequest): JsonResponse
    {
        try {
            $newUser = $this->userRegistrationService->register($registrationRequest);

            return new JsonResponse([
                'message' => 'User successfully created',
                'user' => $newUser,
            ], Response::HTTP_CREATED);
        } catch(Throwable) {
            return new JsonResponse([
                'message' => 'Failed to register user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
