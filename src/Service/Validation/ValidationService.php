<?php

namespace App\Service\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {}

    public function getErrors(array $data, array $constraints): array
    {
        $violations = $this->validator->validate($data, new Collection($constraints));

        $errors = [];
        /** @var ConstraintViolation $error */
        foreach ($violations as $error) {
            $path = $error->getPropertyPath();
            $path = str_replace('][', '.', $path);
            $path = trim($path, '[]');
            $errors[$path] = $error->getMessage();
        }

        return $errors;
    }

    public function validate(array $data, array $constraints): void
    {
        $errors = $this->getErrors($data, $constraints);

        if (count($errors) > 0) {
            $exception = new ArgumentResolverValidationException('Validations failed');
            $exception->setErrors($errors);
            throw $exception;
        }
    }
}
