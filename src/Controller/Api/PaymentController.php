<?php

namespace App\Controller\Api;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PaymentController
 * @package App\Controller
 * @Route("/api/payment")
 */
class PaymentController extends AbstractController
{
    private $session;
    private $logger;

    public function __construct(SessionInterface $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="payment", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function index(Request $request)
    {
        $basketItems = $this->session->get('purchase-basket', []);
        $images = [];
        $paymentFormattedItems = [];
        $isDev = $this->getParameter('kernel.environment') === 'dev';
        foreach ($basketItems as $item) {
            $imageUrl = 'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/'. $item['imagePath'] . '.png';
            $images[] = $imageUrl;
            $paymentFormattedItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item['price'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$imageUrl],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];
        }
        Stripe::setApiKey($_ENV['STRIPE_API_KEY']);
        $successUrl = $this->generateUrl('success',  [], UrlGeneratorInterface::NETWORK_PATH) . '?session_id={CHECKOUT_SESSION_ID}';
        $successUrl = $isDev ? 'http:' . $successUrl : 'https:' . $successUrl;
        $cancelUrl = $this->generateUrl('home',  [], UrlGeneratorInterface::NETWORK_PATH);
        $cancelUrl = $isDev ? 'http:' . $cancelUrl : 'https:' . $cancelUrl;
        /** @var User $user */
        $user = $this->getUser();
        $checkoutSession = Session::create([
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['FR'],
            ],
            'payment_method_types' => ['card'],
            'line_items' => $paymentFormattedItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer' => $user->getCustomerId(),
        ]);
        return $this->json(['id' => $checkoutSession->id, 'images' => $images]);
    }
}
