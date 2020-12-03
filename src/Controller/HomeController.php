<?php

namespace App\Controller;

use App\Service\MailerHelper;
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

    public function __construct(SessionInterface $session, MailerHelper $mailerHelper)
    {
        $this->session = $session;
        $this->mailhelper = $mailerHelper;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function success(Request $request) {
        Stripe::setApiKey($_ENV['STRIPE_API_KEY']);
        $session = Session::retrieve($request->query->get('session_id'));
        $customer = Customer::retrieve($session['customer']);
        $basket = $this->session->get('purchase-basket');
        $this->mailhelper->newOrderPassedEmail($basket, $session, $customer);
        $this->session->remove('purchase-basket');

        return $this->render('home/success.html.twig');
    }
}
