<?php

namespace App\Controller;

use App\Entity\Wine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/wine")
 * Class WineController
 * @package App\Controller
 */
class WineController extends AbstractController
{

    /**
     * @Route("/load", methods={"GET"})
     */
    public function getWines(SerializerInterface $serializer)
    {
        $wines = $this->getDoctrine()->getRepository(Wine::class)->findAll();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $serializedWines = $serializer->serialize($wines, 'json');

        return $this->json($serializedWines);
    }
}
