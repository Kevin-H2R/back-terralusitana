<?php

namespace App\Controller\Api;

use App\Entity\Wine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BasketController
 * @package App\Controller
 * @Route("/api/basket")
 */
class BasketController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="add_to_basket", methods={"POST"})
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
            'id' => $wine->getId(),
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
     * @Route("/", name="get_basket", methods={"GET"})
     */
    public function getBasket()
    {
        $basket = $this->session->get('purchase-basket', []);
        return $this->json($basket);
    }

    /**
     * @Route("/remove", name="remove_from_basket", methods={"POST"})
     */
    public function remove(Request $request)
    {
        $basket = $this->session->get('purchase-basket', []);
        $idToRemove = json_decode($request->getContent(), true);

        for ($i = 0; $i < count($basket); ++$i) {
            if ($basket[$i]['id'] === $idToRemove) {
                array_splice($basket, $i, 1);
            }
        }
        $this->session->set('purchase-basket', $basket);

        return $this->json([]);
    }

    /**
     * @Route("/update", name="update_basket", methods={"POST"})
     */
    public function update(Request $request)
    {
        $basket = $this->session->get('purchase-basket', []);
        $data = json_decode($request->getContent(), true);
        for ($i = 0; $i < count($basket); ++$i) {
            if ($basket[$i]['id'] !== $data['id'] ||
                $basket[$i]['quantity'] === $data['newQuantity']) {
                continue;
            }
            $basket[$i]['quantity'] = $data['newQuantity'];
            $basket[$i]['totalPrice'] = $basket[$i]['price'] * $data['newQuantity'];
        }
        $this->session->set('purchase-basket', $basket);
        return $this->json([]);
    }
}
