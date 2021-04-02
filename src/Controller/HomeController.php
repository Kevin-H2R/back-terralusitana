<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Wine;
use App\Service\MailerHelper;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $session;
    private $mailhelper;
    private $logger;

    public function __construct(SessionInterface $session, MailerHelper $mailerHelper, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->mailhelper = $mailerHelper;
        $this->logger = $logger;
    }

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
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function success(Request $request) {
        Stripe::setApiKey($_ENV['STRIPE_API_KEY']);
        $session = Session::retrieve($request->query->get('session_id'));
        $customer = Customer::retrieve($session['customer']);
        $basket = $this->session->get('purchase-basket');

        $order = new Order();
        $order->setDate(new \DateTime());
        $order->setUser($this->getUser());
        $manager = $this->getDoctrine()->getManager();
        $wineRepository = $this->getDoctrine()->getRepository(Wine::class);
        foreach ($basket as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->setParentOrder($order);
            $orderDetail->setQuantity($item['quantity']);
            $orderDetail->setUnitePrice($item['price']);
            $orderDetail->setWine($wineRepository->find($item['id']));
            $manager->persist($orderDetail);
            $order->addOrderDetail($orderDetail);
        }
        $manager->persist($order);
        $manager->flush();
        $this->mailhelper->newOrderPassedEmail($basket, $session, $customer);
        $this->session->remove('purchase-basket');

        return $this->render('home/success.html.twig');
    }
}
