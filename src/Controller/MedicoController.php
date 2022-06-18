<?php

namespace App\Controller;

use App\Entity\Medico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MedicoController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/medico", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $corpoReq = \json_decode($request->getContent());

        $medico = new Medico();
        $medico->crm = $corpoReq->crm;
        $medico->nome = $corpoReq->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();
        return new JsonResponse($medico);
    }

    /**
     * @Route("/medico", methods={"GET"})
     */
    public function findAll(Request $request): Response
    {
        $medRepo = $this->getDoctrine()->getRepository(Medico::class);
        return new JsonResponse($medRepo->findAll());
    }


    /**
     * @Route("/medico/{id}", methods={"GET"})
     */
    public function find(Request $request): Response
    {
        $medRepo = $this->getDoctrine()->getRepository(Medico::class);
        $medico = $medRepo->find($request->get('id'));
        $codRetorno = $medico ? Response::HTTP_OK: Response::HTTP_NO_CONTENT ;

        return new JsonResponse($medico , $codRetorno);
    }

}