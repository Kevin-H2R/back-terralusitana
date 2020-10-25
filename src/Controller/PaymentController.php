<?php

namespace App\Controller;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
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
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="payment", methods={"POST"})
     */
    public function index()
    {
        $package = new Package(new JsonManifestVersionStrategy(__DIR__.'/../../public/build/manifest.json'));
        $basketItems = $this->session->get('purchase-basket', []);
        $images = [];
        $paymentFormattedItems = [];
        foreach ($basketItems as $item) {
            $image = $package->getUrl('build/' . $item['imagePath'] . '.png');
            $images[] = $image;
            $paymentFormattedItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item['price'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$image],
                    ]
                ],
                'quantity' => $item['quantity']
            ];
        }
//        $paymentFormattedItems = array_map(function ($item) use ($package, $images) {
//            $image = $package->getUrl('build/' . $item['imagePath'] . '.png');
//            $images[] = $image;
//            return [
//                'price_data' => [
//                    'currency' => 'eur',
//                    'unit_amount' => $item['price'] * 100,
//                    'product_data' => [
//                        'name' => $item['name'],
//                        'images' => [$image],
//                    ]
//                ],
//                'quantity' => $item['quantity']
//            ];
//        }, $basketItems);

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
