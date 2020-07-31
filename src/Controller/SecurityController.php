<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/logout", name="app_logout", methods={"GET"})
     * @throws \Exception
     */
    public function logout()
    {
        // do not need to do anything in this controller, already handles by security.yaml
        throw new \Exception("Don't forget to activate logout");
    }
}
