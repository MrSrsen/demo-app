<?php

namespace App\Service;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ArgumentResolverValidationException extends InvalidArgumentException
{
    private array $errors;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function populateErrorsWithViolationsList(ConstraintViolationListInterface $violations): void
    {
        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $path = $violation->getPropertyPath();
            $path = str_replace('][', '.', $path);
            $path = trim($path, '[]');
            $errors[$path] = $violation->getMessage();
        }

        $this->setErrors($errors);
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
