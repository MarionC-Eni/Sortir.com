<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationFailureListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onAuthenticationFailure(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AuthenticationException) {
            // Enregistrez l'exception dans les journaux
            $this->logger->error('Échec de l\'authentification : ' . $exception->getMessage());
        }
    }

}