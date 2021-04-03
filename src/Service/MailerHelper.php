<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class MailerHelper
{
    private $mailer;
    private $engine;
    private $environment;
    private $logger;

    public function __construct(\Swift_Mailer $mailer, Environment $engine, KernelInterface $kernel, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->environment = $kernel->getEnvironment();
        $this->logger = $logger;
    }

    public function newOrderPassedEmail(array $basket, $checkoutSession, $customer)
    {
        $total = array_reduce($basket, function($acc, $cur) {
            return $acc + ($cur['quantity'] * $cur['price']);
        }, 0);
        $this->logger->debug("Sending checkout mail for basket: " . json_encode($basket));
        $message = (new \Swift_Message('['. strtoupper($this->environment) .'] Nouvelle commande'))
            ->setFrom('contact@terra-lusitana.com')
            ->setTo('contact@terra-lusitana.com')
            ->setBody(
                $this->engine->render(
                    'emails/checkout.html.twig', [
                        'basket' => $basket,
                        'total' => $total,
                        'session' => $checkoutSession,
                        'customer' => $customer,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sendAdminRegistrationEmail(string $email)
    {
        $message = (new \Swift_Message('['. strtoupper($this->environment) .'] Mail de nouvelle inscription'))
            ->setFrom('contact@terra-lusitana.com')
            ->setTo('contact@terra-lusitana.com')
            ->setBody(
                $this->engine->render(
                    'emails/registration.html.twig',
                    ['email' => $email]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

//    public function sendChangePasswordEmail(string $email)
//    {
//        $message = (new \Swift_Message(''))
//    }
}