<?php

namespace App\Controller;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PaymentController
 * @package App\Controller
 * @Route("/payment")
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
        $package = new Package(new JsonManifestVersionStrategy(__DIR__.'/../../public/build/manifest.json'));
        $basketItems = $this->session->get('purchase-basket', []);
        $images = [];
        $paymentFormattedItems = [];
        $isDev = $this->getParameter('kernel.environment') === 'dev';
        foreach ($basketItems as $item) {
            $imageUrl = $package->getUrl('build/' . $item['imagePath'] . '.png');
            if (!$isDev) {
                $imageUrl = 'https://' . $request->getHttpHost() . $imageUrl;
            }
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
                'quantity' => $item['quantity']
            ];
        }
        Stripe::setApiKey($_ENV['STRIPE_API_KEY']);
        $this->logger->debug('https:' . $this->generateUrl('success',  [], UrlGeneratorInterface::NETWORK_PATH));
        $successUrl = $this->generateUrl('success',  [], UrlGeneratorInterface::NETWORK_PATH);
        $successUrl = $isDev ? 'http:' . $successUrl : 'https:' . $successUrl;
        $cancelUrl = $this->generateUrl('home',  [], UrlGeneratorInterface::NETWORK_PATH);
        $cancelUrl = $isDev ? 'http:' . $cancelUrl : 'https:' . $cancelUrl;
        $checkoutSession = Session::create([
            'billing_address_collection' => 'required',
            'payment_method_types' => ['card'],
            'line_items' => $paymentFormattedItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,

        ]);
        return $this->json(['id' => $checkoutSession->id, 'images' => $images]);
    }
}
