<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ArgumentResolverValidationException extends RuntimeException
{
    private array $errors;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrorsAsViolations(ConstraintViolationListInterface $violations): void
    {
        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $path = $violation->getPropertyPath();
            $path = str_replace('][', '.', $path);
            $path = trim($path, '[]');
            $errors[$path] = $violation->getMessage();
        }

        $this->errors = $errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
