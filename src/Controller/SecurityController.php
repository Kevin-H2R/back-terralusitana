<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AuthenticationHelper;
use App\Service\MailerHelper;
use Psr\Log\LoggerInterface;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param AuthenticationHelper $authenticationHelper
     * @param MailerHelper $mailerHelper
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthenticationHelper $authenticationHelper,
        MailerHelper $mailerHelper)
    {
        $email = null;
        $firstname = null;
        $lastname = null;
        try {
            $manager = $this->getDoctrine()->getManager();
            $sentData = json_decode($request->getContent(), true);
            $user = new User();
            $email = htmlspecialchars(filter_var($sentData['email'], FILTER_SANITIZE_EMAIL));
            $firstname = htmlspecialchars($sentData['firstname']);
            $lastname = htmlspecialchars($sentData['lastname']);
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                htmlspecialchars($sentData['password'])
            ));
            $user->setRoles([]);
            $manager->persist($user);
            $manager->flush();
        } catch (\Exception $e) {
            $this->logger->error($e);
            return $this->json(['error'], 409);
        }

        try {
            $fullname = ucfirst(strtolower($firstname)) . ' ' .
                ucfirst(strtolower($lastname));
            Stripe::setApiKey($_ENV['STRIPE_API_KEY']);
            $customer = Customer::create(['email' => $sentData['email'], 'name' => $fullname]);
            $user->setCustomerId($customer['id']);
            $manager->flush();
        } catch (ApiErrorException $e) {
        }

        $authenticationHelper->logUserAfterRegistration($request, $user);
        $mailerHelper->sendAdminRegistrationEmail($sentData['email']);

        return $this->json([]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     * @throws \Exception
     */
    public function logout()
    {
        // do not need to do anything in this controller, already handles by security.yaml
        throw new \Exception("Don't forget to activate logout");
    }
}
