<?php

namespace App\Controller;

use App\Request\UserRegistrationRequest;
use App\Service\UserRegistrationService;
use App\Service\Validation\ArgumentResolverValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController
{
    public function __construct(
        private UserRegistrationService $userRegistrationService,
        private ValidatorInterface $validator,
    ) {}

    #[Route('/user', name: 'register_user', methods: ['POST'])]
    public function register(UserRegistrationRequest $registrationRequest): JsonResponse
    {
        try {
            $newUser = $this->userRegistrationService->register($registrationRequest);

            return new JsonResponse([
                'message' => 'User successfully created',
                'user' => $newUser,
            ], Response::HTTP_CREATED);
        } catch (ArgumentResolverValidationException $exception) {
            return new JsonResponse([
                'message' => 'Invalid user data',
                'errors' => $exception->getErrors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch(\Throwable $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
                // 'message' => 'Failed to register user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
