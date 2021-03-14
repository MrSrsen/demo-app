<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Request\UserRegistration\UserRegistrationRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserRegistrationService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RoleRepository $roleRepository,
    ) {}

    /**
     * @param UserRegistrationRequest $registrationRequest
     * @return User
     * @throws EntityNotFoundException
     */
    public function register(UserRegistrationRequest $registrationRequest): User
    {
        $userRole = $this->roleRepository->findOneById($registrationRequest->getRoleId());

        $newUser = new User();
        $newUser->setFirstName($registrationRequest->getFirstName());
        $newUser->setLastName($registrationRequest->getLastName());
        $newUser->setEmail($registrationRequest->getEmail());
        $newUser->setPassword(hash("sha512", $registrationRequest->getPassword()));
        $newUser->setRole($userRole);

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();

        return $newUser;
    }
}
