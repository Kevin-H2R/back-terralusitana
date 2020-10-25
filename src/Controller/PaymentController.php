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
        foreach ($basketItems as $item) {
            $imageUrl = $package->getUrl('build/' . $item['imagePath'] . '.png');
            if ($this->getParameter('kernel.environment') !== 'dev') {
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

        Stripe::setApiKey('sk_test_D46VQamnB1YzH2IIUMgNBkXc00kelOEPvi');
        $this->logger->debug($this->generateUrl('home',  array('type' => 'param'), UrlGeneratorInterface::ABSOLUTE_URL));
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $paymentFormattedItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success',  [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('home',  [], UrlGeneratorInterface::ABSOLUTE_URL),

        ]);
        return $this->json(['id' => $checkoutSession->id, 'images' => $images]);
    }
}
