<?php


namespace App\Controller\Api;


use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class OrderController
 * @package App\Controller\Api
 * @Route("/api/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function getOrders()
    {
        /** @var User $user */
        $user = $this->getUser();
        $orderRepository = $this->getDoctrine()->getRepository(Order::class);
        $orders = $orderRepository->findBy(['user' => $user->getId()]);
        $serializedOrders = [];
        /** @var Order $order */
        foreach ($orders as $order) {
            $orderDetails = $order->getOrderDetails()->toArray();
            $serializedOrderDetails = [];
            $price = .0;
            /** @var OrderDetail $orderDetail */
            foreach ($orderDetails as $orderDetail) {
                $wine = $orderDetail->getWine();
                $unitePrice = $orderDetail->getUnitePrice();
                $quantity = $orderDetail->getQuantity();
                $serializedOrderDetails[] = [
                    'wine' => $wine->getName(),
                    'image' => $wine->getImagePath(),
                    'quantity' => $quantity,
                    'unitePrice' => $unitePrice,
                ];
                $price += $unitePrice * $quantity;
            }

            $serializedOrders[] = [
                'date' => $order->getDate()->format('d-m-Y'),
                'items' => $serializedOrderDetails,
                'totalPrice' => $price,
            ];
        }

        return $this->json($serializedOrders);
    }
}