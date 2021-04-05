<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Service\MailerHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/account")
 * Class AccountController
 * @package App\Controller\Api
 */
class AccountController extends AbstractController
{
    private $mailerHelper;
    public function __construct(MailerHelper $mailerHelper)
    {
        $this->mailerHelper = $mailerHelper;
    }

    /**
     * @Route("/information", methods={"GET"})
     */
    public function index()
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user === null) {
            return $this->json([], 404);
        }
        return $this->json([
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        ]);
    }

    /**
     * @Route("/information", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function modify(Request $request)
    {
        $sentData = json_decode($request->getContent(), true);
        $manager = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        $user->setFirstname($sentData['firstname']);
        $user->setLastname($sentData['lastname']);
        $manager->flush();

        return $this->json([]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/test")
     */
    public function mailTest()
    {
        $this->mailerHelper->test();
        return $this->json([]);
    }

    
}
