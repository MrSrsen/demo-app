<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class UserRegistrationRequest
{
    public function __construct(
        #[NotBlank]
        private string $firstName,

        #[NotBlank]
        private string $lastName,

        #[NotBlank]
        #[Email]
        private string $email,

        #[NotBlank]
        private string $password,

        #[NotBlank]
        private string $passwordVerify,

        #[NotBlank]
        #[Type(['type' => 'integer'])]
        private int $roleId,
    ) {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordVerify(): string
    {
        return $this->passwordVerify;
    }

    public function hasSamePasswords(): bool
    {
        return $this->password === $this->passwordVerify;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }
}
