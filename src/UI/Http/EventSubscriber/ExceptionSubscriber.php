<?php

namespace App\UI\Http\EventSubscriber;

use App\UI\Http\Response\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private ApiResponse $apiResponse;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $code = null;

        if ($exception->getCode() > 0) {
            $code = $exception->getCode();
        }

        $response = $this->apiResponse
            ->withError($exception->getMessage())
            ->withCode($code ?? Response::HTTP_INTERNAL_SERVER_ERROR)
            ->response();

        $event->setResponse($response);
    }
}