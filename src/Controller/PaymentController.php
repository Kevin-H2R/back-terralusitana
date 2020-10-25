<?php

namespace App\Controller;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
        foreach ($basketItems as $item) {
            $imageUrl = $package->getUrl('build/' . $item['imagePath'] . '.png');
            if ($this->getParameter('kernel.environment') !== 'dev') {
                $imageUrl = 'https://' . $request->getHttpHost() . $imageUrl;
            }
            $this->logger->error("========================= IMAGE URL =========================");
            $this->logger->error($imageUrl);
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


        Stripe::setApiKey('sk_test_D46VQamnB1YzH2IIUMgNBkXc00kelOEPvi');
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $paymentFormattedItems,
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success.html',
            'cancel_url' => 'http://localhost:8000/cancel.html',

        ]);
        return $this->json(['id' => $checkoutSession->id, 'images' => $images]);
    }
}
