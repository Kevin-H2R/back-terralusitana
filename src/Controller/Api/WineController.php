<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use App\Entity\Wine;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/wine")
 * Class WineController
 * @package App\Controller
 */
class WineController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getWines(SerializerInterface $serializer)
    {
        $wines = $this->getDoctrine()->getRepository(Wine::class)->findAll();
        $serializedWines = [];
        /** @var Wine $wine */
        foreach ($wines as $wine) {
            $serializedWine  = [
                'id' => $wine->getId(),
                'name' => $wine->getName(),
                'imagePath' => $wine->getImagePath(),
                'region' => ['name' => $wine->getRegion()->getName(), 'imagePath' => $wine->getRegion()->getImagePath()],
                'price' => $wine->getPrice(),
                'varieties' => array_map(function ($var) {return ['name' => $var->getName()];}, $wine->getVarieties()->toArray()),
            ];
            $serializedWines[] = $serializedWine;
        }

        return $this->json($serializedWines);
    }
}
