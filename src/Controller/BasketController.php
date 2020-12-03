<?php

namespace App\Controller;

use App\Entity\Wine;
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
        $sentData = json_decode($request->getContent(), true);
        $id = $sentData['id'];
        $quantity = $sentData['quantity'];
        /** @var Wine $wine */
        $wine = $this->getDoctrine()->getRepository(Wine::class)->find($id);
        $found = false;
        for ($i = 0; $i < count($basket); ++$i) {
            if ($basket[$i]['name'] === $wine->getName()) {
                $basket[$i]['quantity'] += $quantity;
                $basket[$i]['totalPrice'] += $wine->getPrice() * $quantity;
                $found = true;
            }
        }
        $item = [
            'name' => $wine->getName(),
            'price' => $wine->getPrice(),
            'quantity' => $quantity,
            'imagePath' => $wine->getImagePath(),
            'totalPrice' => $wine->getPrice() * $quantity,
        ];
        if (!$found) {
            $basket[] = $item;
        }
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
