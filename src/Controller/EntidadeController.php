<?php

namespace App\Controller;

use App\Entity\Especialidade;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntidadeController extends AbstractController
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
     * @Route("/entidade", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $corpoReq = \json_decode($request->getContent());

        $especialidade = new Especialidade();
        $especialidade->setDescricao($corpoReq->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();
        return new JsonResponse($especialidade);
    }
}
