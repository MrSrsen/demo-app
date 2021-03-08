<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class RoleController extends AbstractController
{
    public function __construct(
        private RoleRepository $roleRepository,
    )
    {}

    #[Route('/role', name: 'list_roles', methods: ['GET'])]
    public function listAll(): JsonResponse
    {
        try {
            return new JsonResponse([
                'roles' => $this->roleRepository->findAll(),
            ]);
        } catch (Throwable) {
            return new JsonResponse([
                'message' => 'Failed to list all roles',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
