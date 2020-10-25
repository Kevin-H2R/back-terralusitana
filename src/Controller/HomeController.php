<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/success", name="success")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function success() {
        return $this->render('home/success.html.twig');
    }
}
