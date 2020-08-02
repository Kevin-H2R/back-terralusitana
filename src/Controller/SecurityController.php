<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthenticationHelper;
use App\Service\MailerHelper;
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param AuthenticationHelper $authenticationHelper
     * @param MailerHelper $mailerHelper
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthenticationHelper $authenticationHelper,
        MailerHelper $mailerHelper)
    {
        try {
            $manager = $this->getDoctrine()->getManager();
            $sentData = json_decode($request->getContent(), true);
            $user = new User();
            $user->setEmail($sentData['email']);
            $user->setFirstname($sentData['firstname']);
            $user->setLastname($sentData['lastname']);
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $sentData['password']
            ));
            $user->setRoles([]);
            $manager->persist($user);
            $manager->flush();
        } catch (\Exception $e) {
            return $this->json(['error'], 500);
        }

        $authenticationHelper->logUserAfterRegistration($request, $user);
        $mailerHelper->sendAdminRegistrationEmail($sentData['email']);

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
