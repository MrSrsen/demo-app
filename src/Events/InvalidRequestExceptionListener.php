<?php

namespace App\Events;

use App\Service\ArgumentResolverValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InvalidRequestExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelRequestException',
        ];
    }

    public function onKernelRequestException(ExceptionEvent $event): void
    {
        /** @var ArgumentResolverValidationException $exception */
        $exception = $event->getThrowable();

        if ($exception::class !== ArgumentResolverValidationException::class) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'message' => $exception->getMessage(),
            'errors' => $exception->getErrors(),
        ], JsonResponse::HTTP_BAD_REQUEST));
    }
}
