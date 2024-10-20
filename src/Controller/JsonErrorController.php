<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class JsonErrorController
{
    public function show(Throwable $exception, LoggerInterface $logger): JsonResponse
    {
        return new JsonResponse([
            'message'       => $exception->getMessage(),
            //'code'          => $exception->getStatusCode(),
            //'traces'        => $exception->getTrace()
        ]);
    }
}