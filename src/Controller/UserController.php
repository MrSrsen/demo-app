<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
    ) {}

    #[Route('/user', name: 'list_users', methods: ['GET'])]
    public function listAll(): JsonResponse
    {
        try {
            return new JsonResponse([
                'users' => $this->userRepository->findAll(),
            ]);
        } catch (Throwable) {
            return new JsonResponse([
                'message' => 'Failed to list all users'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
