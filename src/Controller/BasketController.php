<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BasketController
 * @package App\Controller
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/add", name="add_to_basket", methods={"POST"})
     */
    public function addToBasket(Request $request)
    {
        $basket = $this->session->get('purchase-basket', []);
        $item = "Vin numero 42";
        $basket[] = $item;
        $this->session->set('purchase-basket', $basket);

        return $this->json($item);
    }

    /**
     * @Route("/get", name="get_basket", methods={"GET"})
     */
    public function getBasket()
    {
        $basket = $this->session->get('purchase-basket', []);
        return $this->json($basket);
    }
}
