<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;

class LoggingMiddleware implements Middleware
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $route = $request->getUri()->getPath();
        $this->logger->info($request->getMethod() . ' ' . $route . ' ' . $request->getBody());
        $response = $handler->handle($request);
        $this->logger->info(
            $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
            [(string)$response->getBody()]
        );

        return $response;
    }
}
