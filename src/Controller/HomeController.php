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
     * @Route("/test", name="test")
     */
    public function test()
    {
        return $this->json(['test' => 'test is working']);
    }

    /**
     * @Route("/score-50%%", name="route_test")
     */
    public function bla()
    {
        return $this->json([]);
    }
}
