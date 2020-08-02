<?php


namespace App\Service;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationHelper
{
    private $eventDispatcher;
    private $tokenStorage;
    private $session;

    public function __construct(EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    public function logUserAfterRegistration(Request $request, User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        //        $this->get('security.token_storage')->setToken($token);
        $this->tokenStorage->setToken($token);
        // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
        $this->session->set('_security_main', serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch($event, "security.interactive_login");
    }
}