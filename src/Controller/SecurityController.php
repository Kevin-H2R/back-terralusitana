<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthenticationHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthenticationHelper $authenticationHelper)
    {
        $manager = $this->getDoctrine()->getManager();
        $sentData = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($sentData['email']);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            $sentData['password']
        ));
        $user->setRoles([]);
        $manager->persist($user);
        $manager->flush();
        $authenticationHelper->logUserAfterRegistration($request, $user);

//        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
//        $this->get('security.token_storage')->setToken($token);
//
//        // If the firewall name is not main, then the set value would be instead:
//        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
//        $this->get('session')->set('_security_main', serialize($token));
//
//        // Fire the login event manually
//        $event = new InteractiveLoginEvent($request, $token);
//        $eventDispatcher->dispatch($event, "security.interactive_login");

        return $this->json([]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     * @throws \Exception
     */
    public function logout()
    {
        // do not need to do anything in this controller, already handles by security.yaml
        throw new \Exception("Don't forget to activate logout");
    }
}
