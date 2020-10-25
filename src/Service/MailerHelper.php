<?php


namespace App\Service;


use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class MailerHelper
{
    private $mailer;
    private $engine;
    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $engine, KernelInterface $kernel)
    {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->environment = $kernel->getEnvironment();
    }

    public function newOrderPassedEmail()
    {

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
}