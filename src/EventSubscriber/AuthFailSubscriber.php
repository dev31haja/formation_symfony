<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class AuthFailSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;    
    }
    
    public function onSymfonyComponentSecurityHttpEventLoginFailureEvent(LoginFailureEvent $event)
    {
        $this->logger->alert("Authentification KO");
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.login.failure' => 'onSecurityAuthenticationFailure',
        ];
    }
}
