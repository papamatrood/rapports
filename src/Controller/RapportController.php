<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RapportController extends AbstractController
{

    #[Route('/my_api/rapports', name: 'rapports', methods: ['GET'])]
    public function getRapportList(RapportRepository $rapportRepository, SerializerInterface $serializer): JsonResponse
    {
        $rapportList = array_reverse($rapportRepository->findAll());
        $jsonRapportList = $serializer->serialize($rapportList, 'json');
        return new JsonResponse($jsonRapportList, Response::HTTP_OK, [], true);
    }

    #[Route('/my_api/addRapport', name: "createRapport", methods: ['POST'])]
    public function createRapport(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $rapport = $serializer->deserialize($request->getContent(), Rapport::class, 'json');

        $em->persist($rapport);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/my_api/editRapport/{id}', name: "updateRapport", methods: ['PUT'])]
    public function updateRapport(Request $request, SerializerInterface $serializer, int $id, RapportRepository $rapportrepo, EntityManagerInterface $em): JsonResponse
    {
        /**
         * @var Rapport
         */
        $rapport = $rapportrepo->find($id);
        $content = $request->toArray();

        $installation = $content['installation'] ?? -1;
        $interqualite = $content['interqualite'] ?? -1;
        $interdepannage = $content['interdepannage'] ?? -1;
        $visite = $content['visite'] ?? -1;
        $recuperation = $content['recuperation'] ?? -1;
        $autre = $content['autre'] ?? -1;

        $rapport->setInstallation($installation);
        $rapport->setInterqualite($interqualite);
        $rapport->setInterdepannage($interdepannage);
        $rapport->setVisite($visite);
        $rapport->setRecuperation($recuperation);
        $rapport->setAutre($autre);

        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/my_api/delete/{id}', name: 'deleteRapport', methods: ['DELETE'])]
    public function deleteRapport(int $id, RapportRepository $rapportrepo, EntityManagerInterface $em): JsonResponse
    {
        $rapport = $rapportrepo->find($id);
        $em->remove($rapport);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}
