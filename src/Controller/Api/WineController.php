<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\OrderDetail;
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
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
            if ($object instanceof Order || $object instanceof OrderDetail) {
                return $object->getId();
            }
                return $object->getName();
            },
        ];
        $normalizer = new ObjectNormalizer(
            null, null, null, null, null, null, $defaultContext
        );

        $serializer = new Serializer([$normalizer], [$encoder]);
        $serializedWines = $serializer->serialize($wines, 'json', ['groups' => 'wine']);

        return $this->json($serializedWines);
    }
}
