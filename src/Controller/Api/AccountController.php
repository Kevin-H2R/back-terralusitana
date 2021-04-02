<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/account")
 * Class AccountController
 * @package App\Controller\Api
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/information", methods={"GET"})
     */
    public function index()
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user === null) {
            return $this->json([], 404);
        }
        return $this->json([
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ]);
    }

    
}
